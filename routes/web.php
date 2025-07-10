<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/google/auth', [AuthController::class, 'googleAuth']);
Route::get('/google/callback', [AuthController::class, 'googleCallback']);

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/sync', [DashboardController::class, 'sync']);
    });
});