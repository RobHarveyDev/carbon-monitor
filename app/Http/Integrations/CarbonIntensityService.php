<?php

namespace App\Http\Integrations;

use App\Http\Integrations\CarbonIntensity\CarbonIntensityConnector;
use App\Http\Integrations\CarbonIntensity\DTO\CarbonIntensityDTO;
use App\Http\Integrations\CarbonIntensity\DTO\CurrentEnergyStatusDTO;
use App\Http\Integrations\CarbonIntensity\DTO\GenerationMixDTO;
use App\Http\Integrations\CarbonIntensity\Requests\Get48hCarbonIntensityFromDateTime;
use App\Http\Integrations\CarbonIntensity\Requests\GetCurrentGenerationMix;
use App\Http\Integrations\CarbonIntensity\Requests\GetCurrentIntensity;
use Saloon\Http\Response;

class CarbonIntensityService
{
    public function __construct(private CarbonIntensityConnector $connector) {}

    public function getCurrentStatus(): CurrentEnergyStatusDTO
    {
        $pool = $this->connector->pool([
            'intensity' => new GetCurrentIntensity,
            'generationMix' => new GetCurrentGenerationMix,
        ]);

        /** @var CarbonIntensityDTO $intensity */
        $intensity = null;
        /** @var GenerationMixDTO[] $generationMix */
        $generationMix = null;

        $pool->withResponseHandler(function (Response $response, string $key) use (&$intensity, &$generationMix) {
            match ($key) {
                'intensity' => $intensity = $response->dto(),
                'generationMix' => $generationMix = $response->dto(),
            };
        });
        $pool->send()->wait();

        return new CurrentEnergyStatusDTO(
            carbonIntensity: $intensity->actualIntensity,
            intensityIndex: $intensity->intensityIndex,
            generationMix: $generationMix
        );
    }

    /**
     * @return CarbonIntensityDTO[]
     */
    public function getIntensityForecast(): array
    {
        $request = new Get48hCarbonIntensityFromDateTime(now());
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return GenerationMixDTO[]
     */
    public function getCurrentGenerationMix(): array
    {
        $request = new GetCurrentGenerationMix;
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
