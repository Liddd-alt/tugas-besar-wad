<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\LostController;
use App\Http\Controllers\FoundController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Lost Items Routes
    Route::resource('lost', LostController::class);

    // Found Items Routes
    Route::resource('found', FoundController::class);

    // Matching Routes
    Route::resource('matching', MatchingController::class);
    Route::put('matching/{id}/status', [MatchingController::class, 'updateStatus'])->name('matching.updateStatus');
    
    // User Management Routes (Admin Only)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UsersController::class);
        Route::resource('category', CategoryController::class);
    });
});
