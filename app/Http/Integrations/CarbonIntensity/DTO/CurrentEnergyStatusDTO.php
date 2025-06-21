<?php

namespace App\Http\Integrations\CarbonIntensity\DTO;

use App\Enums\FuelGenerationType;
use App\Enums\IntensityIndex;

class CurrentEnergyStatusDTO
{
    /**
     * Represents the current carbon intensity and generation mix of energy.
     *
     * @param  int  $carbonIntensity  The current carbon intensity in gCO2eq/kWh.
     * @param  IntensityIndex  $intensityIndex  The index representing the carbon intensity level.
     * @param  FuelGenerationType[]  $generationMix  An array of GenerationMixDTO objects representing the current generation mix.
     */
    public function __construct(
        public int $carbonIntensity,
        public IntensityIndex $intensityIndex,
        public array $generationMix,
    ) {}
}
