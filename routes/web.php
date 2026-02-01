<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Route for testing API
Route::get('/test-api', [TestController::class, 'testApi']);

// Routes for favorites management - only these require auth
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
    Route::post('/favorites', [FavoritesController::class, 'store'])->name('favorites.store');
    Route::put('/favorites/{favorite}', [FavoritesController::class, 'update'])->name('favorites.update');
    Route::delete('/favorites/{favorite}', [FavoritesController::class, 'destroy'])->name('favorites.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
