<?php

namespace App\Http\Integrations\CarbonIntensity\DTO;

use App\Enums\FuelGenerationType;

class GenerationMixDTO
{
    public function __construct(
        public FuelGenerationType $fuelType,
        public float $percentage,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            FuelGenerationType::fromString($data['fuel']),
            (float) $data['perc']
        );
    }
}
