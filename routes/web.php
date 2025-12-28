<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RecipeController;
use App\Models\Recipe;

Route::get('/', function () {
    return inertia('Homepage');
});

Route::get('/dashboard', function () {
    return inertia('Dashboard', [
        'user' => auth()->user(),
        'recipes' => Recipe::where('user_id', auth()->id())->latest()->get(),
    ]);
})->middleware('auth')->name('dashboard');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/create-recipe', function(){
    return inertia('CreateRecipe', ['user' => auth()->user(),]);
})->name('create-recipe');

Route::post('/create-recipe', [RecipeController::class, 'store'])->name('store-recipe');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');