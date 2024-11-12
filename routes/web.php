<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Category related routes
    Route::get('categories/upload', [CategoryController::class, 'showUploadForm'])->name('categories.upload');
    Route::post('categories/upload', [CategoryController::class, 'uploadCsv'])->name('categories.uploadCsv');
    Route::resource('categories', controller: CategoryController::class);

});



require __DIR__.'/auth.php';
