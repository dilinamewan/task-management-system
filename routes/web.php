<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Export routes (must come before resource routes)
    Route::get('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');
    
    Route::resource('tasks', TaskController::class);
    // Add duplicate route
    Route::post('/tasks/{task}/duplicate', [TaskController::class, 'duplicate'])->name('tasks.duplicate');
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        // Export routes for users (must come before resource routes)
        Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
        
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';