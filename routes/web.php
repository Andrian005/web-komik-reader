<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChapterPageController;
use App\Http\Controllers\ComicTitleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::get('login-admin', [LoginAdminController::class, 'index'])->name('login-admin');
Route::post('auth-admin', [LoginAdminController::class, 'login'])->name('auth-admin');
Route::post('logout-admin', [LoginAdminController::class, 'logout'])->name('logout-admin');

Route::middleware('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('master-data')->group(function () {
            Route::prefix('genre')->group(function () {
                Route::get('/', [GenreController::class, 'index'])->name('dashboard.master-data.genre.index');
                Route::get('create', [GenreController::class, 'create'])->name('dashboard.master-data.genre.create');
                Route::post('store', [GenreController::class, 'store'])->name('dashboard.master-data.genre.store');
                Route::get('view/{id}', [GenreController::class, 'view'])->name('dashboard.master-data.genre.view');
                Route::get('edit/{id}', [GenreController::class, 'edit'])->name('dashboard.master-data.genre.edit');
                Route::post('update/{id}', [GenreController::class, 'update'])->name('dashboard.master-data.genre.update');
                Route::post('delete/{id}', [GenreController::class, 'delete'])->name('dashboard.master-data.genre.delete');
            });

            Route::prefix('author')->group(function () {
                Route::get('/', [AuthorController::class, 'index'])->name('dashboard.master-data.author.index');
                Route::get('create', [AuthorController::class, 'create'])->name('dashboard.master-data.author.create');
                Route::post('store', [AuthorController::class, 'store'])->name('dashboard.master-data.author.store');
                Route::get('view/{id}', [AuthorController::class, 'view'])->name('dashboard.master-data.author.view');
                Route::get('edit/{id}', [AuthorController::class, 'edit'])->name('dashboard.master-data.author.edit');
                Route::post('update/{id}', [AuthorController::class, 'update'])->name('dashboard.master-data.author.update');
                Route::post('delete/{id}', [AuthorController::class, 'delete'])->name('dashboard.master-data.author.delete');
            });

            Route::prefix('artist')->group(function () {
                Route::get('/', [ArtistController::class, 'index'])->name('dashboard.master-data.artist.index');
                Route::get('create', [ArtistController::class, 'create'])->name('dashboard.master-data.artist.create');
                Route::post('store', [ArtistController::class, 'store'])->name('dashboard.master-data.artist.store');
                Route::get('view/{id}', [ArtistController::class, 'view'])->name('dashboard.master-data.artist.view');
                Route::get('edit/{id}', [ArtistController::class, 'edit'])->name('dashboard.master-data.artist.edit');
                Route::post('update/{id}', [ArtistController::class, 'update'])->name('dashboard.master-data.artist.update');
                Route::post('delete/{id}', [ArtistController::class, 'delete'])->name('dashboard.master-data.artist.delete');
            });
        });

        Route::prefix('manage-comics')->group(function () {
            Route::prefix('comic-titles')->group(function () {
                Route::get('/', [ComicTitleController::class, 'index'])->name('dashboard.manage-comics.comic-titles.index');
                Route::get('create', [ComicTitleController::class, 'create'])->name('dashboard.manage-comics.comic-titles.create');
                Route::post('store', [ComicTitleController::class, 'store'])->name('dashboard.manage-comics.comic-titles.store');
                Route::get('view/{id}', [ComicTitleController::class, 'view'])->name('dashboard.manage-comics.comic-titles.view');
                Route::get('edit/{id}', [ComicTitleController::class, 'edit'])->name('dashboard.manage-comics.comic-titles.edit');
                Route::post('update/{id}', [ComicTitleController::class, 'update'])->name('dashboard.manage-comics.comic-titles.update');
                Route::post('delete/{id}', [ComicTitleController::class, 'delete'])->name('dashboard.manage-comics.comic-titles.delete');

                Route::prefix('chapter')->group(function () {
                    Route::get('create/{comic_title_id}', [ChapterController::class, 'create'])->name('dashboard.manage-comics.comic-titles.chapter.create');
                    Route::post('store/{comic_title_id}', [ChapterController::class, 'store'])->name('dashboard.manage-comics.comic-titles.chapter.store');
                    Route::get('view-chapter/{comic_title_id}', [ChapterController::class, 'viewChapter'])->name('dashboard.manage-comics.comic-titles.chapter.view-chapter');
                    Route::get('edit/{chapter}', [ChapterController::class, 'edit'])->name('dashboard.manage-comics.comic-titles.chapter.edit');
                    Route::post('update/{chapter}', [ChapterController::class, 'update'])->name('dashboard.manage-comics.comic-titles.chapter.update');
                    Route::post('delete/{chapter}', [ChapterController::class, 'delete'])->name('dashboard.manage-comics.comic-titles.chapter.delete');
                    Route::post('chapter-pages/upload', [ChapterPageController::class, 'upload'])->name('chapter_pages.upload');
                    Route::post('chapter-pages/delete', [ChapterPageController::class, 'delete'])->name('chapter_pages.delete');
                });
            });
        });
    });
});
