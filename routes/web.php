<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/v1/cs');

// Serve static Vue admin login without .html extension
Route::get('/vue/ad/login', function () {
    $path = public_path('vue/ad/login.html');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
});

Route::prefix('v1')->group(function () {
    // include per-service route definitions
    $base = base_path('routes/v1');

    foreach ([
        // 'cs.php',
        // 'us.php',
        'ad.php',
        // 'ot.php',
    ] as $f) {
        $path = $base . DIRECTORY_SEPARATOR . $f;
        if (file_exists($path)) {
            require $path;
        }
    }
});
