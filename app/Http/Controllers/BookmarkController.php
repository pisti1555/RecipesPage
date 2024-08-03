<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Recipe;
use App\Models\Bookmark;

class BookmarkController extends Controller
{

    public function index(Request $request) {
        if  (!auth()) {
            return redirect()->route('login');
        }

        $bookmarks = auth()->user()->bookmarks()->with('recipe')->get()->pluck('recipe');
        
        return view('bookmarks.index', [
            'bookmarks' => $bookmarks
        ]);
    }

    public function store($id)
    {
        $user = auth()->user();
        $recipe = Recipe::findOrFail($id);

        if ($user->bookmarks()->where('recipe_id', $id)->exists()) {
            return redirect()->back();
        }

        $user->bookmarks()->create(['recipe_id' => $id]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $bookmark = $user->bookmarks()->where('recipe_id', $id)->first();

        if ($bookmark) {
            $bookmark->delete();
            return redirect()->back();
        }

        return redirect()->back();
    }
}
