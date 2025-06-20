<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use App\Enums\IntensityIndex;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IntensityIndexTest extends TestCase
{
    public function test_from_string_returns_correct_enum_case()
    {
        $this->assertSame(IntensityIndex::VERY_LOW, IntensityIndex::fromString('very low'));
        $this->assertSame(IntensityIndex::LOW, IntensityIndex::fromString('low'));
        $this->assertSame(IntensityIndex::MODERATE, IntensityIndex::fromString('moderate'));
        $this->assertSame(IntensityIndex::HIGH, IntensityIndex::fromString('high'));
        $this->assertSame(IntensityIndex::VERY_HIGH, IntensityIndex::fromString('very high'));
    }

    public function test_from_string_is_case_insensitive()
    {
        $this->assertSame(IntensityIndex::VERY_LOW, IntensityIndex::fromString('VeRy LoW'));
        $this->assertSame(IntensityIndex::LOW, IntensityIndex::fromString('LOW'));
        $this->assertSame(IntensityIndex::MODERATE, IntensityIndex::fromString('MoDeRaTe'));
        $this->assertSame(IntensityIndex::HIGH, IntensityIndex::fromString('HIGH'));
        $this->assertSame(IntensityIndex::VERY_HIGH, IntensityIndex::fromString('VERY HIGH'));
    }

    public function test_from_string_throws_on_invalid_value()
    {
        $this->expectException(InvalidArgumentException::class);
        IntensityIndex::fromString('invalid');
    }
}

