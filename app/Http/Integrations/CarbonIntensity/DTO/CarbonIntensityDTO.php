<?php

namespace App\Http\Integrations\CarbonIntensity\DTO;

use App\Enums\IntensityIndex;
use Carbon\Carbon;
use JsonSerializable;

readonly class CarbonIntensityDTO implements JsonSerializable
{
    public function __construct(
        public Carbon $periodFrom,
        public Carbon $periodTo,
        public ?int $actualIntensity,
        public int $forecastIntensity,
        public IntensityIndex $intensityIndex,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            Carbon::parse($data['from']),
            Carbon::parse($data['to']),
            $data['intensity']['actual'],
            $data['intensity']['forecast'],
            IntensityIndex::fromString($data['intensity']['index'])
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'periodFrom' => $this->periodFrom->toIso8601ZuluString(),
            'periodTo' => $this->periodTo->toIso8601ZuluString(),
            'actualIntensity' => $this->actualIntensity,
            'forecastIntensity' => $this->forecastIntensity,
            'intensityIndex' => $this->intensityIndex->value,
        ];
    }
}
