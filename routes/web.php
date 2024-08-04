<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\BookmarkController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function() {
    return view('welcome');
})->name('home');

Route::get('/', function() {
    return redirect()->route('recipes.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/update-info', [ProfileController::class, 'updateInfo'])->name('profile.update-info');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::post('/recipes', [RecipesController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/create', [RecipesController::class, 'create'])->name('recipes.create');
    Route::post('/recipes/save/{id}', [RecipesController::class, 'save'])->name('recipes.save');
    Route::patch('/recipes/{id}', [RecipesController::class,'update'])->name('recipes.update');
    Route::delete('/recipes/{id}', [RecipesController::class, 'destroy'])->name('recipes.destroy');
    Route::get('/recipes/{id}/edit', [RecipesController::class,'edit'])->name('recipes.edit');
    Route::get('/recipes/{id}/rate', [RecipesController::class,'rate'])->name('recipes.rate');
    Route::patch('/recipes/{id}/rate', [RecipesController::class,'rate_update'])->name('recipes.rate.update');
    Route::get('/recipes/get', [RecipesController::class, 'getRecipes'])->name('recipes.get');

    Route::get('/bookmark', [BookmarkController::class,'index'])->name('bookmarks.index');
    Route::post('/bookmark/{id}', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmark/{id}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
});

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/recipes', [RecipesController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{id}', [RecipesController::class, 'show'])->name('recipes.show');


require __DIR__.'/auth.php';
