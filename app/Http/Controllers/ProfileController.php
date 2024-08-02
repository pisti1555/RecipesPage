<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile.profile', [
            'user' => auth()->user(),
            'profile' => auth()->user()->profile,
            'recipes' => auth()->user()->recipes,
        ]);
    }

    public function show($username): View
    {
        $user = User::query()->where("username", $username)->firstOrFail();
        $profile = $user->profile;
        return view('profile.profile', [
            'user' => $user,
            'profile' => $profile,
            'recipes' => $user->recipes,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'profile' => $request->user()->profile,
        ]);
    }

    public function updateInfo(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'image' => 'image',
            'description' => '',
            'show_name' => '',
            'show_email' => '',
        ]);

        if ($request['image'] != null) {
            $img_path = $request->image->store('profile', 'public');
            $data['image'] = $img_path;
        }

        $request->user()->profile()->update($data);
        return redirect()->route('profile.edit')->with('status','success');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
