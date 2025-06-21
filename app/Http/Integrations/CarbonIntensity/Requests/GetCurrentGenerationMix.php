<?php

namespace App\Http\Integrations\CarbonIntensity\Requests;

use App\Http\Integrations\CarbonIntensity\DTO\GenerationMixDTO;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetCurrentGenerationMix extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/generation';
    }

    /**
     * @return GenerationMixDTO[]
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $data) => GenerationMixDTO::fromApiResponse($data),
            $response->json('data.0.generationmix')
        );
    }
}
