<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// MIDDLEWARE
use App\Http\Middleware\isLogin;
use App\Http\Middleware\isAdmin;
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
        Route::get('/', 'index')->name('index')
            ->middleware(isAdmin::class);
        Route::get('/{id}', 'show')->name('show')
            ->middleware(isAdmin::class);
        Route::post('/', 'store')->name('store')
            ->middleware(isAdmin::class);
        Route::post('/{id}', 'update')->name('update')
            ->middleware(isAdmin::class);
        Route::delete('/{id}', 'delete')->name('delete')
            ->middleware(isAdmin::class);
    });

    // LOCATIONS
    Route::controller(LocationController::class)
    ->prefix('location')->name('location.')->group(function () {
        Route::get('/', 'index')->name('index')
            ->middleware(isAdmin::class);
        Route::get('/{id}', 'show')->name('show')
            ->middleware(isAdmin::class);
        Route::post('/', 'store')->name('store')
            ->middleware(isAdmin::class);
        Route::post('/{id}', 'update')->name('update')
            ->middleware(isAdmin::class);
        Route::delete('/{id}', 'delete')->name('delete')
            ->middleware(isAdmin::class);
    });

    // SUPPLIERS
    Route::controller(SupplierController::class)
    ->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', 'index')->name('index')
            ->middleware(isAdmin::class);
        Route::get('/{id}', 'show')->name('show')
            ->middleware(isAdmin::class);
        Route::post('/', 'store')->name('store')
            ->middleware(isAdmin::class);
        Route::post('/{id}', 'update')->name('update')
            ->middleware(isAdmin::class);
        Route::delete('/{id}', 'delete')->name('delete')
            ->middleware(isAdmin::class);
    });

    // ITEMS
    Route::controller(ItemController::class)
    ->prefix('item')->name('item.')->group(function () {
        Route::get('/', 'index')->name('index')
            ->middleware(isAdmin::class);
        Route::get('/{id}', 'show')->name('show')
            ->middleware(isAdmin::class);
        Route::post('/', 'store')->name('store')
            ->middleware(isAdmin::class);
        Route::post('/{id}', 'update')->name('update')
            ->middleware(isAdmin::class);
        Route::delete('/{id}', 'delete')->name('delete')
            ->middleware(isAdmin::class);
    });
});
