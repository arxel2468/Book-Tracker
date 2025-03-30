<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReadingStatusController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Book routes
Route::resource('books', BookController::class);
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::post('/books/import', [BookController::class, 'importFromGoogle'])->name('books.import');

// Author routes
Route::resource('authors', AuthorController::class);

// Reading status routes
Route::put('/books/{book}/reading-status', [ReadingStatusController::class, 'update'])->name('reading-status.update');