<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'Laravel' => app()->version(),
        'Message' => 'test'
    ];
});

require __DIR__.'/auth.php';
