<?php

use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::get('login-admin', [LoginAdminController::class, 'index'])->name('login-admin');
Route::post('auth-admin', [LoginAdminController::class, 'login'])->name('auth-admin');
Route::post('logout-admin', [LoginAdminController::class, 'logout'])->name('logout-admin');

Route::middleware('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('master')->group(function () {
            Route::prefix('genre')->group(function () {
                Route::get('/', [GenreController::class, 'index'])->name('dashboard.master.genre.index');
                Route::post('store', [GenreController::class, 'store'])->name('dashboard.master.genre.store');
            });
        });
    });
});
