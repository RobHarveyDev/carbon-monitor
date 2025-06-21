<?php

namespace App\Http\Controllers\Intensity;

use App\Http\Integrations\CarbonIntensityService;
use Illuminate\Http\JsonResponse;

class GetCarbonIntensityForecastController
{
    public function __construct(private CarbonIntensityService $service) {}

    public function __invoke(): JsonResponse
    {
        $forecast = $this->service->getIntensityForecast();

        return response()->json($forecast);
    }
}
