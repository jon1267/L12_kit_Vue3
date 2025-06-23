<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('products', ProductController::class)->middleware(['auth']);
Route::resource('posts', PostController::class)->middleware(['auth']);
Route::get('quiz', function () { return Inertia::render('quiz/Index'); })->middleware(['auth'])->name('quiz.index');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
