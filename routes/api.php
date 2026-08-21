<?php

use App\Http\Controllers\Api\StationController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:station-api')->group(function (): void {
    Route::get('/stations/summary', [StationController::class, 'summary']);
    Route::get('/stations', [StationController::class, 'index']);
});
