<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Recipe;
use App\Models\Bookmark;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::latest()->get();
        return view('recipes.index', ['recipes' => $recipes]);
    }

    public function show($id): View
    {
        $recipe = Recipe::findOrFail($id);

        $bookmarked = Bookmark::where('user_id', auth()->user()->id)
            ->where('recipe_id', $recipe->id)
            ->exists();

        return view('recipes.show', [
            'recipe' => $recipe,
            'bookmarked'=> $bookmarked
        ]);
    }

    public function create(): View
    {
        $categories = array_column(Categories::cases(), 'value');
        return view('recipes.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $categories = array_column(Categories::cases(), 'value');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'image' => ['required', 'image'],
            'category' => ['required', 'string', 'in:' . implode(',', $categories)],
            'ingredients' =>  ['required', 'string'],
            'instructions' => ['required', 'string'],
            'difficulty' => ['required', 'integer', 'between:1,10'],
            'time' => ['required', 'integer', 'between:1,500']
        ]);

        $img_path = $request->image->store('uploads', 'public');
        $validated['image'] = $img_path;
        
        auth()->user()->recipes()->create( $validated );
        return redirect()->route('profile.index');
    }

    public function edit(string $id)
    {
        $recipe = Recipe::findOrFail($id);

        $categories = array_column(Categories::cases(), 'value');
        if (auth()->user()->recipes->contains($recipe)) {
            return view('recipes.edit', [
                'recipe' => $recipe,
                'categories' => $categories
            ]);
        }

        return redirect('recipes.show',  $id);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $recipe = Recipe::findOrFail($id);
        if (!auth()->user()->recipes->contains($recipe)) {
            return redirect('recipes.show',  $id);
        }

        $categories = array_column(Categories::cases(), 'value');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'image' => ['image'],
            'category' => ['required', 'string', 'in:' . implode(',', $categories)],
            'ingredients' =>  ['required', 'string'],
            'instructions' => ['required', 'string'],
            'difficulty' => ['required', 'integer', 'between:1,10'],
            'time' => ['required', 'integer', 'between:1,500']
        ]);

        if ($request->image != null) {
            $img_path = $request->image->store('uploads', 'public');
            $validated['image'] = $img_path;
        }

        $recipe->update($validated);
        return redirect()->route('recipes.show', $recipe->id)->with('status','success');
    }

    public function destroy(string $id): RedirectResponse
    {
        $recipe = Recipe::findOrFail($id);
        if (auth()->user()->recipes->contains($recipe)) {
            auth()->user()->recipes->find($recipe)->delete();
            return redirect()->route('profile.index');
        }
        return redirect('recipes.show', $id);
    }

    public function rate(string $id)
    {
        $recipe = Recipe::findOrFail($id);

        if (auth()->user()->recipes->contains($recipe)) {
            return redirect()->route('recipes.show', $recipe->id);
        }

        return view('recipes.rate', [
            'recipe'=> $recipe,
        ]);
    }

    public function rate_update(Request $request, string $id): RedirectResponse
    {
        $recipe = Recipe::findOrFail($id);
        
        if (auth()->user()->recipes->contains($recipe)) {
            return redirect()->route('recipes.show', $recipe->id);
        }

        if ($recipe->ratings->count() > 0) {
            $existingRating = $recipe->ratings()->where('user_id', auth()->id())->first();
            if ($existingRating) {
                $data = $request->validate([
                    'rating' => ['required', 'integer', 'between:1,5'],
                    'comment' => ['nullable', 'string', 'max:500'],
                ]);
                $existingRating->update($data);
                return redirect()->route('recipes.show', $recipe->id);
            }
        }
        
        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:500'],
        ]);
        $data = array_merge($data, [
            'recipe_id' => $recipe->id, 
        ]);

        auth()->user()->ratings()->create($data);

        return redirect()->route('recipes.show', $id);
    }
}
