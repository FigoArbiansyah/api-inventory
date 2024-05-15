<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// MIDDLEWARE
use App\Http\Middleware\isLogin;
// CONTROLLER
use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        // AUTENTIKASI
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware(isLogin::class);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me'])->middleware(isLogin::class);
    });
});
