<?php

use Illuminate\Support\Facades\Route;
use Techlink\Blog\Http\Controllers\CategoryController;
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

//category routes
Route::as('categories.')->group(function() {
   Route::get('categories', [CategoryController::class, 'index'])->name('index');
   Route::get('categories/{category:id}-{slug}', [CategoryController::class, 'show'])->name('show');

    Route::middleware('auth')->group(function() {
        Route::get('categories/create', [CategoryController::class, 'create'])->name('create');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('categories', [CategoryController::class, 'store'])->name('store');
        Route::delete('categories/{category:id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('update');
    });
});
