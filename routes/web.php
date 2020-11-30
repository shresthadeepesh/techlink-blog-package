<?php

use Illuminate\Support\Facades\Route;
use Techlink\Blog\Http\Controllers\PostController;

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post:id}', [PostController::class, 'show'])->name('posts.show');