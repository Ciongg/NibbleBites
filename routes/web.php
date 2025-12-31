<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProfileController;
use App\Models\Recipe;

Route::get('/', function () {
    return inertia('Homepage');
});

Route::get('/dashboard', function () {
    return inertia('Dashboard', [
        'recipes' => Recipe::latest()->get(),
    ]);
})->middleware('auth')->name('dashboard');


Route::get('/recipes', function () {
    return inertia('YourRecipes', [
        'recipes' => auth()->user()->recipes()->get(),
    ]);
})->middleware('auth')->name('your-recipes');


Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->middleware('auth')->name('view-recipe');
Route::post('/recipes/{recipe}/nibble', [RecipeController::class, 'toggle'])->middleware('auth')->name('toggle-nibble');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/create-recipe', function(){
    return inertia('CreateRecipe');
})->middleware('auth')->name('create-recipe');

Route::post('/create-recipe', [RecipeController::class, 'store'])->name('store-recipe');



Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile.show');
Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');