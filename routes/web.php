<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CustomAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/signup', [AuthController::class, 'registerView'])->name('signup');
Route::post('/signup', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(CustomAuth::class)->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('edit-profile');
    Route::post('/edit-profile', [ProfileController::class, 'update'])->name('update-profile');

    Route::get('/edit-password', [ProfileController::class, 'edit_password'])->name('edit-password');
    Route::post('/edit-password', [ProfileController::class, 'update_password'])->name('update-password');

    Route::resource('categories', CategoryController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
});
