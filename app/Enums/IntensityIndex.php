<?php

namespace App\Enums;

use InvalidArgumentException;

enum IntensityIndex: string
{
    case VERY_LOW = 'very low';
    case LOW = 'low';
    case MODERATE = 'moderate';
    case HIGH = 'high';
    case VERY_HIGH = 'very high';

    public static function fromString(string $value): self
    {
        return match (strtolower($value)) {
            'very low' => self::VERY_LOW,
            'low' => self::LOW,
            'moderate' => self::MODERATE,
            'high' => self::HIGH,
            'very high' => self::VERY_HIGH,
            default => throw new InvalidArgumentException("Unknown intensity index: $value"),
        };
    }
}
