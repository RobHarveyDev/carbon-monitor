<?php

use App\Http\Controllers\Intensity\GetCarbonIntensityForecastController;
use App\Http\Controllers\Intensity\GetCurrentCarbonIntensityController;
use App\Http\Controllers\Intensity\GetCurrentGenerationMixController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/intensity/now', GetCurrentCarbonIntensityController::class)->name('intensity.now');
Route::get('/intensity/forecast', GetCarbonIntensityForecastController::class)->name('intensity.forecast');
Route::get('/intensity/generation/now', GetCurrentGenerationMixController::class)->name('intensity.generation.now');
