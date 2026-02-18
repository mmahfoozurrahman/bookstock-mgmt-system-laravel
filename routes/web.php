<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;







Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/signup', [AuthController::class, 'register'])->name('signup');
Route::post('/signup', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
// Route::middleware('auth.custom')->group(function () {
Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('edit-profile');
Route::get('/edit-password', [ProfileController::class, 'edit_password'])->name('edit-password');

Route::resource('categories', CategoryController::class);
Route::resource('authors', AuthorController::class);
Route::resource('books', BookController::class);
// });
