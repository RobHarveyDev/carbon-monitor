<?php

namespace App\Http\Controllers\Intensity;

use App\Http\Integrations\CarbonIntensityService;

class GetCurrentGenerationMixController
{
    public function __construct(private CarbonIntensityService $service) {}

    public function __invoke()
    {
        $generationMix = $this->service->getCurrentGenerationMix();

        return response()->json($generationMix);
    }
}
