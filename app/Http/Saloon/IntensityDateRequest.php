<?php

namespace App\Http\Saloon;

use App\Http\Saloon\DTO\IntensityDataDTO;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class IntensityDateRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct() {}

    public function resolveEndpoint(): string
    {
        return '/intensity/date';
    }

    public function createDtoFromResponse(Response $response): IntensityDataDTO
    {
        return IntensityDataDTO::fromApiResponse($response->json('data'));
    }
}
