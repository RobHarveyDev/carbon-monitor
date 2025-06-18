<?php

namespace App\Http\Saloon\DTO;

class IntensityDataDTO
{
    public array $actual;
    public array $forecast;

    public function __construct(array $actual, array $forecast)
    {
        $this->actual = $actual;
        $this->forecast = $forecast;
    }
}
