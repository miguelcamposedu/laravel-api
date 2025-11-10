<?php
require __DIR__ . '/auth.php';

use App\Http\Controllers\SecuenciaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('secuencias', SecuenciaController::class);
});
