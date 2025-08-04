<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfoController;
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
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index']);
            Route::post('/upload', [DashboardController::class, 'upload']);
            Route::get('/sync', [DashboardController::class, 'sync']);
            Route::prefix('f')->group(function () {
                Route::get('/{id}', [DashboardController::class, 'show']);
                Route::get('/{id}/info', [InfoController::class, 'info']);
                Route::get('/{id}/stream', [InfoController::class, 'stream']);
                Route::get('/{id}/download', [InfoController::class, 'download']);
                Route::post('/{id}/rename', [InfoController::class, 'rename']);
            });
        });
        Route::post('/search', [DashboardController::class, 'search']);
    });

    Route::get('/logout', [AuthController::class, 'logout']);
});