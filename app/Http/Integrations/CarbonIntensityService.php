<?php

namespace App\Http\Integrations;

use App\Http\Integrations\CarbonIntensity\CarbonIntensityConnector;
use App\Http\Integrations\CarbonIntensity\DTO\CarbonIntensityDTO;
use App\Http\Integrations\CarbonIntensity\Requests\Get48hCarbonIntensityFromDateTime;
use App\Http\Integrations\CarbonIntensity\Requests\GetCurrentIntensity;

class CarbonIntensityService
{
    public function __construct(private CarbonIntensityConnector $connector) {}

    public function getCurrentIntensity(): CarbonIntensityDTO
    {
        $request = new GetCurrentIntensity;
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
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
}
