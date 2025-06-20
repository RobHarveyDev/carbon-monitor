<?php

namespace App\Http\Integrations\CarbonIntensity\Requests;

use App\Http\Integrations\CarbonIntensity\DTO\CarbonIntensityDTO;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetCurrentIntensity extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/intensity';
    }

    public function createDtoFromResponse(Response $response): CarbonIntensityDTO
    {
        return CarbonIntensityDTO::fromApiResponse($response->json('data')[0]);
    }
}
