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

    public static function fromApiResponse(array $data): self
    {
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
        return new self($actual, $forecast);
    }
}
