<?php

namespace App\Http\Controllers\Intensity;

use App\Http\Integrations\CarbonIntensityService;
use Illuminate\Http\JsonResponse;

class GetCurrentCarbonIntensityController
{
    public function __construct(private CarbonIntensityService $service) {}

    public function __invoke(): JsonResponse
    {
        $intensity = $this->service->getCurrentIntensity();
        return response()->json($intensity);
    }
}
