<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarrierController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/carriers', [CarrierController::class, 'index'])->name('carriers.index');

require __DIR__.'/auth.php';
