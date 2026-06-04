<?php

use Illuminate\Support\Facades\Route;

// Other area prefix: /v1/ot
Route::prefix('ot')->group(function () {
    Route::get('/error', [App\Http\Controllers\Other\ErrorController::class, 'index']);
    Route::get('/error/{message_id}', [App\Http\Controllers\Other\ErrorController::class, 'index']);

    // AdminBake examples
    Route::prefix('admin-bake')->group(function () {
        Route::get('/admin-accounts', [App\Http\Controllers\Other\AdminBake\AdminAccountsController::class, 'index']);
        Route::get('/admin-accounts/add', [App\Http\Controllers\Other\AdminBake\AdminAccountsController::class, 'add']);
        Route::get('/admin-accounts/view/{id}', [App\Http\Controllers\Other\AdminBake\AdminAccountsController::class, 'view']);
        Route::get('/admin-accounts/edit/{id}', [App\Http\Controllers\Other\AdminBake\AdminAccountsController::class, 'edit']);
        Route::get('/admin-accounts/delete/{id}', [App\Http\Controllers\Other\AdminBake\AdminAccountsController::class, 'delete']);
    });

    // SampleBake
    Route::prefix('sample-bake')->group(function () {
        Route::get('/my-sql-type-samples', [App\Http\Controllers\Other\SampleBake\MySqlTypeSamplesController::class, 'index']);
        Route::get('/my-sql-type-samples/add', [App\Http\Controllers\Other\SampleBake\MySqlTypeSamplesController::class, 'add']);
        Route::get('/my-sql-type-samples/view/{id}', [App\Http\Controllers\Other\SampleBake\MySqlTypeSamplesController::class, 'view']);
        Route::get('/my-sql-type-samples/edit/{id}', [App\Http\Controllers\Other\SampleBake\MySqlTypeSamplesController::class, 'edit']);
        Route::get('/my-sql-type-samples/delete/{id}', [App\Http\Controllers\Other\SampleBake\MySqlTypeSamplesController::class, 'delete']);
    });

    // SampleCode -> MySqlTypeSamples
    Route::prefix('sample_code')->group(function () {
        Route::prefix('my_sql_type_samples')->group(function () {
            Route::get('/', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\SearchController::class, 'init']);
            Route::get('/search', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\SearchController::class, 'index']);
            Route::get('/detail/{my_sql_type_sample_id}', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\DetailController::class, 'index']);
            Route::get('/create', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\CreateController::class, 'index']);
            Route::get('/create/{process_id}/input', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\CreateController::class, 'input']);
            Route::post('/create/{process_id}/input', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\CreateController::class, 'inputPost']);
            Route::get('/create/{process_id}/conf', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\CreateController::class, 'conf']);
            Route::post('/create/{process_id}/conf', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\CreateController::class, 'confPost']);
            Route::get('/create/{my_sql_type_sample_id}/copy', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\CreateController::class, 'copy']);
            Route::get('/edit/{my_sql_type_sample_id}', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\EditController::class, 'index']);
            Route::get('/edit/{process_id}/input', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\EditController::class, 'input']);
            Route::post('/edit/{process_id}/input', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\EditController::class, 'inputPost']);
            Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\EditController::class, 'conf']);
            Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\EditController::class, 'confPost']);
            Route::get('/delete/{my_sql_type_sample_id}', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\DeleteController::class, 'index']);
            Route::post('/delete/{my_sql_type_sample_id}', [App\Http\Controllers\Other\SampleCode\MySqlTypeSamples\DeleteController::class, 'indexPost']);
        });
    });
});
