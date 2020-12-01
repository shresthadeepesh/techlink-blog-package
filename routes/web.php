<?php

use Illuminate\Support\Facades\Route;
use Techlink\Blog\Http\Controllers\PostController;

//post routes
Route::as('posts.')->group(function() {
    Route::get('posts', [PostController::class, 'index'])->name('index');
    Route::get('posts/{post:id}-{slug}', [PostController::class, 'show'])->name('show');

    Route::middleware('auth')->group(function() {
        Route::get('posts/create', [PostController::class, 'create'])->name('create');
        Route::get('posts/{post:id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::post('posts', [PostController::class, 'store'])->name('store');
        Route::delete('posts/{post:id}', [PostController::class, 'destroy'])->name('destroy');
        Route::put('posts/{post:id}', [PostController::class, 'update'])->name('update');
    });
});