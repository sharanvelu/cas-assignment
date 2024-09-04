<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('projects', \App\Http\Controllers\ProjectController::class);

Route::prefix('projects/{project}/integrations')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProjectIntegrationController::class, 'index'])->name('projects.integrations.index');
    Route::patch('/', [\App\Http\Controllers\ProjectIntegrationController::class, 'update'])->name('projects.integrations.update');
});

Route::resource('projects/{project}/articles', \App\Http\Controllers\ArticleController::class);

Route::post('projects/{project}/articles/{article}/publish', [\App\Http\Controllers\ArticleController::class, 'publish'])->name('articles.publish');
