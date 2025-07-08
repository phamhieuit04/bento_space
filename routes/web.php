<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/google/auth', [AuthController::class, 'googleAuth'])->name('login');
Route::get('/google/callback', [AuthController::class, 'googleCallback']);

Route::get('/dashboard', [DashboardController::class, 'index']);