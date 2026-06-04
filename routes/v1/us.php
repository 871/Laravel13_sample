<?php

use Illuminate\Support\Facades\Route;

// User area prefix: /v1/us
Route::prefix('us')->group(function () {
    Route::get('/error', [App\Http\Controllers\User\ErrorController::class, 'index']);
    Route::get('/error/{message_id}', [App\Http\Controllers\User\ErrorController::class, 'index']);
    Route::get('/login', [App\Http\Controllers\User\LoginController::class, 'index']);
    Route::post('/login', [App\Http\Controllers\User\LoginController::class, 'indexPost']);

    Route::prefix('{account_id}')->group(function () {
        Route::get('/logout', [App\Http\Controllers\User\LogoutController::class, 'index']);
        Route::post('/logout', [App\Http\Controllers\User\LogoutController::class, 'indexPost']);

        Route::middleware(['userAuth', 'pageAccessLog'])->group(function () {
            Route::get('/error', [App\Http\Controllers\User\ErrorController::class, 'index']);
            Route::get('/error/{message_id}', [App\Http\Controllers\User\ErrorController::class, 'index']);
            Route::get('/', [App\Http\Controllers\User\TopController::class, 'index']);
        });
    });
});
