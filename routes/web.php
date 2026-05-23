<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\WeeklyEditionController;
use App\Http\Controllers\WorldInBriefController;
use App\Http\Controllers\InsiderEpisodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/sections/{slug}', [SectionController::class, 'show'])->name('sections.show');

Route::get('/weekly-edition', [WeeklyEditionController::class, 'index'])->name('weekly-edition.index');
Route::get('/weekly-edition/{slug}', [WeeklyEditionController::class, 'show'])->name('weekly-edition.show');

Route::get('/world-in-brief', [WorldInBriefController::class, 'index'])->name('world-in-brief');

Route::get('/insider', [InsiderEpisodeController::class, 'index'])->name('insider.index');
Route::get('/insider/{slug}', [InsiderEpisodeController::class, 'show'])->name('insider.show');
