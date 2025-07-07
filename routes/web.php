<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/google/auth', [AuthController::class, 'googleAuth'])->name('login');
Route::get('/google/callback', [AuthController::class, 'googleCallback']);