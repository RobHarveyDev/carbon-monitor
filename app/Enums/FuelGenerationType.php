<?php

namespace App\Enums;

enum FuelGenerationType: string
{
    case Gas = 'Gas';
    case Coal = 'Coal';
    case Biomass = 'Biomass';
    case Nuclear = 'Nuclear';
    case Hydro = 'Hydro';
    case Imports = 'Imports';
    case Other = 'Other';
    case Wind = 'Wind';
    case Solar = 'Solar';

    public static function fromString(string $value): ?self
    {
        return match (strtolower($value)) {
            'gas' => self::Gas,
            'coal' => self::Coal,
            'biomass' => self::Biomass,
            'nuclear' => self::Nuclear,
            'hydro' => self::Hydro,
            'imports' => self::Imports,
            'other' => self::Other,
            'wind' => self::Wind,
            'solar' => self::Solar,
            default => null,
        };
    }
}
