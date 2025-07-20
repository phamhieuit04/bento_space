<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::group(['prefix' => 'google'], function () {
    Route::get('/auth', [AuthController::class, 'auth']);
    Route::get('/callback', [AuthController::class, 'callback']);
    Route::get('/refresh_token', [AuthController::class, 'refreshToken']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/sync', [DashboardController::class, 'sync']);
        Route::group(['prefix' => 'f'], function () {
            Route::get('/{id}', [DashboardController::class, 'show']);
            Route::get('/{id}/info', [InfoController::class, 'info']);
            Route::get('/{id}/download', [InfoController::class, 'download']);
        });
        Route::post('/search', [DashboardController::class, 'search']);
    });
});