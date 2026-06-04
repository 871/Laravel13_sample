<?php

use Illuminate\Support\Facades\Route;

// Customer area prefix: /v1/cs
Route::prefix('cs')->group(function () {
    Route::get('/error', [App\Http\Controllers\Custmer\ErrorController::class, 'index']);
    Route::get('/error/{message_id}', [App\Http\Controllers\Custmer\ErrorController::class, 'index']);
    Route::get('/', [App\Http\Controllers\Custmer\MainController::class, 'index']);
});
