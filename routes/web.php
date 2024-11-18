<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route, viewable by any authenticated user
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // User related routes, restricted to admin only
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
   
    // Books related routes
    Route::get('books/upload', [BookController::class, 'showUploadForm'])->name('books.upload');
    Route::post('books/upload', [BookController::class, 'upload'])->name('books.upload.post');
    Route::resource('books', BookController::class);

    // Route to show the form to issue a book
    Route::get('issues/create', [IssueController::class, 'create'])->name('issues.create');
    // Route to store the issued book data
    Route::post('issues', [IssueController::class, 'store'])->name('issues.store');
    // Route to show all issued books
    Route::get('issues', [IssueController::class, 'index'])->name('issues.index');
    // Route to return a book and update the issue record
    Route::post('issues/{id}/return', [IssueController::class, 'returnBook'])->name('issues.return');
    // Route to view details of a specific issue
    Route::get('issues/{id}', [IssueController::class, 'show'])->name('issues.show');
});

require __DIR__.'/auth.php';
