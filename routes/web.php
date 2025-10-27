<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Posts\Index;
use App\Livewire\Posts\Edit;

Route::get('/', fn () => redirect()->route('posts.index'));

Route::get('/posts', Index::class)->name('posts.index');
Route::get('/posts/{post}/edit', Edit::class)->name('posts.edit');
