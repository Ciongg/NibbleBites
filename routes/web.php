<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return inertia('Homepage');
});

Route::get('/dashboard', function () {
    return inertia('Dashboard', ['user' => auth()->user(),]);
})->middleware('auth')->name('dashboard');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');