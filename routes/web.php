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

        Route::prefix('manajemen-komik')->group(function () {
            Route::prefix('genre')->group(function () {
                Route::get('/', [GenreController::class, 'index'])->name('dashboard.manajemen-komik.genre.index');
                Route::get('view/{id}', [GenreController::class, 'view'])->name('dashboard.manajemen-komik.genre.view');
                Route::get('create', [GenreController::class, 'create'])->name('dashboard.manajemen-komik.genre.create');
                Route::get('edit/{id}', [GenreController::class, 'edit'])->name('dashboard.manajemen-komik.genre.edit');
                Route::post('store', [GenreController::class, 'store'])->name('dashboard.manajemen-komik.genre.store');
                Route::post('update/{id}', [GenreController::class, 'update'])->name('dashboard.manajemen-komik.genre.update');
                Route::post('delete/{id}', [GenreController::class, 'delete'])->name('dashboard.manajemen-komik.genre.delete');
            });
        });
    });
});
