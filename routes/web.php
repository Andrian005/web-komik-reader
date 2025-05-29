<?php

use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\JudulController;
use Illuminate\Support\Facades\Route;

Route::get('login-admin', [LoginAdminController::class, 'index'])->name('login-admin');
Route::post('auth-admin', [LoginAdminController::class, 'login'])->name('auth-admin');
Route::post('logout-admin', [LoginAdminController::class, 'logout'])->name('logout-admin');

Route::middleware('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('manajemen-komik')->group(function () {
            Route::prefix('judul')->group(function () {
                Route::get('/', [JudulController::class, 'index'])->name('dashboard.manajemen-komik.judul.index');
                Route::get('view/{id}', [JudulController::class, 'view'])->name('dashboard.manajemen-komik.judul.view');
                Route::get('create', [JudulController::class, 'create'])->name('dashboard.manajemen-komik.judul.create');
                Route::get('edit/{id}', [JudulController::class, 'edit'])->name('dashboard.manajemen-komik.judul.edit');
                Route::post('store', [JudulController::class, 'store'])->name('dashboard.manajemen-komik.judul.store');
                Route::post('update/{id}', [JudulController::class, 'update'])->name('dashboard.manajemen-komik.judul.update');
                Route::post('delete/{id}', [JudulController::class, 'delete'])->name('dashboard.manajemen-komik.judul.delete');
            });

            Route::prefix('genre')->group(function () {
                Route::get('/', [GenreController::class, 'index'])->name('dashboard.manajemen-komik.genre.index');
                Route::get('view/{id}', [GenreController::class, 'view'])->name('dashboard.manajemen-komik.genre.view');
                Route::get('create', [GenreController::class, 'create'])->name('dashboard.manajemen-komik.genre.create');
                Route::get('edit/{id}', [GenreController::class, 'edit'])->name('dashboard.manajemen-komik.genre.edit');
                Route::post('store', [GenreController::class, 'store'])->name('dashboard.manajemen-komik.genre.store');
                Route::post('update/{id}', [GenreController::class, 'update'])->name('dashboard.manajemen-komik.genre.update');
                Route::post('delete/{id}', [GenreController::class, 'delete'])->name('dashboard.manajemen-komik.genre.delete');
            });

            Route::prefix('author')->group(function () {
                Route::get('/', [AuthorController::class, 'index'])->name('dashboard.manajemen-komik.author.index');
                Route::get('view/{id}', [AuthorController::class, 'view'])->name('dashboard.manajemen-komik.author.view');
                Route::get('create', [AuthorController::class, 'create'])->name('dashboard.manajemen-komik.author.create');
                Route::get('edit/{id}', [AuthorController::class, 'edit'])->name('dashboard.manajemen-komik.author.edit');
                Route::post('store', [AuthorController::class, 'store'])->name('dashboard.manajemen-komik.author.store');
                Route::post('update/{id}', [AuthorController::class, 'update'])->name('dashboard.manajemen-komik.author.update');
                Route::post('delete/{id}', [AuthorController::class, 'delete'])->name('dashboard.manajemen-komik.author.delete');
            });
        });
    });
});
