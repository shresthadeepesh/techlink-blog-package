<?php

use Illuminate\Support\Facades\Route;
use Techlink\Blog\Http\Controllers\PostController;

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('posts/{post:id}-{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/{post:id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');
Route::delete('posts/{post:id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::put('posts/{post:id}', [PostController::class, 'update'])->name('posts.update');

//Route::resource('posts', PostController::class);