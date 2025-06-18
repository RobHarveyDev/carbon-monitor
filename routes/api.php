<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/intensity/today', [App\Http\Controllers\CarbonIntensityController::class, 'today'])
    ->name('intensity.today');
