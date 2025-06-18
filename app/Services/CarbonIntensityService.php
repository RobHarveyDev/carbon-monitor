<?php

namespace App\Services;

use App\Http\Saloon\DTO\IntensityDataDTO;
use App\Http\Saloon\GenerationRequest;
use App\Http\Saloon\IntensityDateRequest;
use App\Http\Saloon\IntensityForward48hRequest;
use App\Http\Saloon\UkCarbonIntensityConnector;
use Carbon\Carbon;

class CarbonIntensityService
{
    public function __construct(private UkCarbonIntensityConnector $connector) {}

    public function getIntensityToday(): IntensityDataDTO
    {
        $request = new IntensityDateRequest;
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getForward48hIntensity(Carbon $from): array
    {
        $request = new IntensityForward48hRequest($from);
        $response = $this->connector->send($request);

        return $response->json();
    }

    public function getGenerationMix(): array
    {
        $request = new GenerationRequest;
        $response = $this->connector->send($request);

        return $response->json();
    }
}
