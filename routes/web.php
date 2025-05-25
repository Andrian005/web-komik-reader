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
                Route::get('view/{id}', [GenreController::class, 'view'])->name('dashboard.master.genre.view');
                Route::get('create', [GenreController::class, 'create'])->name('dashboard.master.genre.create');
                Route::get('edit/{id}', [GenreController::class, 'edit'])->name('dashboard.master.genre.edit');
                Route::post('store', [GenreController::class, 'store'])->name('dashboard.master.genre.store');
                Route::post('update/{id}', [GenreController::class, 'update'])->name('dashboard.master.genre.update');
                Route::post('delete/{id}', [GenreController::class, 'delete'])->name('dashboard.master.genre.delete');
            });
        });
    });
});
