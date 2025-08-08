<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Drive\DashboardController;
use App\Http\Controllers\Drive\InfoController;
use App\Http\Controllers\Drive\StarController;
use App\Http\Controllers\Drive\TrashController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::prefix('google')->group(function () {
    Route::get('/auth', [AuthController::class, 'auth']);
    Route::get('/callback', [AuthController::class, 'callback']);
    Route::get('/refresh_token', [AuthController::class, 'refreshToken']);
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('drive')->group(function () {
        Route::post('/search', [DashboardController::class, 'search']);
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index']);
            Route::post('/create', [DashboardController::class, 'create']);
            Route::post('/upload', [DashboardController::class, 'upload']);
            Route::get('/sync', [DashboardController::class, 'sync']);
            Route::prefix('f')->group(function () {
                Route::get('/{id}', [DashboardController::class, 'show']);
                Route::get('/{id}/info', [InfoController::class, 'info']);
                Route::get('/{id}/stream', [InfoController::class, 'stream']);
                Route::get('/{id}/download', [InfoController::class, 'download']);
                Route::post('/{id}/rename', [InfoController::class, 'rename']);
                Route::get('/{id}/trash', [TrashController::class, 'trash']);
                Route::get('/{id}/delete', [TrashController::class, 'delete']);
                Route::get('/{id}/restore', [TrashController::class, 'restore']);
                Route::get('/{id}/star', [DashboardController::class, 'star']);
                Route::get('/{id}/unstar', [DashboardController::class, 'unstar']);
            });
        });
        Route::prefix('trash')->group(function () {
            Route::get('/', [TrashController::class, 'index']);
            Route::get('/empty', [TrashController::class, 'empty']);
        });
        Route::prefix('starred')->group(function () {
            Route::get('/', [StarController::class, 'index']);
        });
    });

    Route::get('/logout', [AuthController::class, 'logout']);
});
