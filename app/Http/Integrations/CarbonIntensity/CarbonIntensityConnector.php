<?php

namespace App\Http\Integrations\CarbonIntensity;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class CarbonIntensityConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.carbonintensity.org.uk';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
