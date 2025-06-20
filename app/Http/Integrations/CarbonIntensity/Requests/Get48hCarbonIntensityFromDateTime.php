<?php

namespace App\Http\Integrations\CarbonIntensity\Requests;

use App\Http\Integrations\CarbonIntensity\DTO\CarbonIntensityDTO;
use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class Get48hCarbonIntensityFromDateTime extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(public Carbon $date) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        $dateString = $this->date->format('Y-m-d\TH:ip');

        return "/intensity/$dateString/fw48h";
    }

    /**
     * Create a DTO array from the response
     *
     * @return CarbonIntensityDTO[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $data) => CarbonIntensityDTO::fromApiResponse($data),
            $response->json('data')
        );
    }
}
