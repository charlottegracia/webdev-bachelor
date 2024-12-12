<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\IncidentController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/carriers', [CarrierController::class, 'store']);
Route::get('carriers/{id}', [CarrierController::class, 'show']);

Route::post('/incidents', [IncidentController::class, 'store']);
Route::put('/incidents/{id}', [IncidentController::class, 'update']);

Route::get('/test', function () {
    return response()->json(['status' => 'API is working']);
});
