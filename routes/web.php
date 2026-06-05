<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/v1/cs');

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
