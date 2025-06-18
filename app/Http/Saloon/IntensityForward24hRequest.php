<?php

namespace App\Http\Saloon;

use App\Http\Saloon\DTO\IntensityDataDTO;
use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class IntensityForward24hRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public Carbon $from) {}

    public function resolveEndpoint(): string
    {
        return '/intensity/'.$this->from->format('Y-m-d\TH:iZ').'/fw24h';
    }

    public function createDtoFromResponse(Response $response): IntensityDataDTO
    {
        $data = $response->json('data') ?? [];
        // Only set forecast, actual should be empty
        $dto = IntensityDataDTO::fromApiResponse($data);

        return new IntensityDataDTO([], $dto->forecast);
    }
}
