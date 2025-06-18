<?php

namespace App\Http\Saloon;

use Saloon\Http\Connector;

class UkCarbonIntensityConnector extends Connector
{
    /**
     * Base URL for the UK Carbon Intensity API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.carbonintensity.org.uk';
    }
}
