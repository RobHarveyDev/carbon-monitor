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
        $data = $response->json('data') ?? [];
        $actual = [];
        $forecast = [];
        foreach ($data as $entry) {
            $datetime = $entry['to'];
            if ($datetime) {
                if (isset($entry['intensity']['actual'])) {
                    $actual[$datetime] = [
                        'intensity' => $entry['intensity']['actual'],
                        'band' => $entry['intensity']['index'],
                    ];
                }
                if (isset($entry['intensity']['forecast'])) {
                    $forecast[$datetime] = [
                        'intensity' => $entry['intensity']['forecast'],
                        'band' => $entry['intensity']['index'],
                    ];
                }
            }
        }

        return new IntensityDataDTO($actual, $forecast);
    }
}
