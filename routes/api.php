<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->name('users.')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')
            ->name('register');
        Route::post('login', 'login')
            ->name('login');
        Route::middleware('auth:sanctum')->get('logout', 'logout')
            ->name('logout');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('info', [UserController::class, 'info'])
            ->name('info');
    });
});

Route::middleware('auth:sanctum')->prefix('finance')->name('finances.')
    ->controller(TransferController::class)->group(function () {
        Route::get('history', 'history')
            ->name('history');
        Route::post('transfer', 'transfer')
            ->name('transfer');
    });

