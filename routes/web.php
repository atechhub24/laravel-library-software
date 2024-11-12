<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard route, viewable by any authenticated user
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Profile related routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Category related routes
    Route::get('categories/upload', [CategoryController::class, 'showUploadForm'])->name('categories.upload');
    Route::post('categories/upload', [CategoryController::class, 'uploadCsv'])->name('categories.uploadCsv');
    Route::resource('categories', CategoryController::class);

    // Author related routes
    Route::get('authors/upload', [AuthorController::class, 'showUploadForm'])->name('authors.upload');
    Route::post('authors/upload', [AuthorController::class, 'upload'])->name('authors.upload.post');
    Route::resource('authors', AuthorController::class);

    // User related routes, restricted to admin only
        // Display all users (index route)
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        
        // Create a new user (create route)
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        
        // Store the new user (store route)
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        
        // Edit user (edit route)
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        
        // Update user (update route)
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        
        // Delete user (destroy route)
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
