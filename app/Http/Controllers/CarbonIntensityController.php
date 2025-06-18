<?php

namespace App\Http\Controllers;

use App\Services\CarbonIntensityService;

class CarbonIntensityController
{
    public function __construct(private CarbonIntensityService $service) {}

    public function today()
    {
        $intensity = $this->service->getIntensityToday();
        return response()->json($intensity);
    }
}
