<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// MIDDLEWARE
use App\Http\Middleware\isLogin;
// CONTROLLER
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        // AUTENTIKASI
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware(isLogin::class);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me'])->middleware(isLogin::class);
    });

    // CATEGORIES
    Route::controller(CategoryController::class)
    ->prefix('category')->name('category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    // LOCATIONS
    Route::controller(LocationController::class)
    ->prefix('location')->name('location.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    });


    Route::get('item', [ItemController::class, 'index']);
});
