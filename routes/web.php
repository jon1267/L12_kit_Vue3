<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('products', ProductController::class)->middleware(['auth']);
Route::resource('posts', PostController::class)->middleware(['auth']);


Route::get('quiz', function () { return Inertia::render('quiz/Index'); })
    ->middleware(['auth'])->name('quiz.index');
Route::get('quiz-stats', [StatController::class, 'index'] )
    ->middleware(['auth'])->name('quiz.stats');
// time: 21:05 lesson 4 (create group && create)

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
