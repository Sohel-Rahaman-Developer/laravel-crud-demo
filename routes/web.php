<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HelloWorld;
use App\Livewire\Posts\Index as PostsIndex;
use App\Livewire\Posts\Edit as PostsEdit;

Route::get('/hello', HelloWorld::class);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', PostsIndex::class)->name('posts.index');
Route::get('/posts/{post}/edit', PostsEdit::class)->name('posts.edit');