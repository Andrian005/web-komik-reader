<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master')->group(function () {
        Route::prefix('genre')->group(function () {
            Route::get('/', [GenreController::class, 'index'])->name('dashboard.master.genre.index');
        });
    });
});
