<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ServiceController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/carriers', [CarrierController::class, 'index'])->name('api.carriers.index');
Route::post('/carriers', [CarrierController::class, 'store']);
Route::get('carriers/{id}', [CarrierController::class, 'show']);

Route::post('/incidents', [IncidentController::class, 'store']);
Route::put('/incidents/{id}', [IncidentController::class, 'update']);

Route::get('/services', [ServiceController::class, 'index'])->name('api.services.index');
Route::post('/services', [ServiceController::class, 'store']);
Route::get('services/{id}', [ServiceController::class, 'show']);

Route::get('/test', function () {
    return response()->json(['status' => 'API is working']);
});
