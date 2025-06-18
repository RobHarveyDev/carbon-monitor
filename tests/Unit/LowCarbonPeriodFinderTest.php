<?php

namespace Tests\Unit;

use App\Services\LowCarbonPeriodFinder;
use PHPUnit\Framework\TestCase;

class LowCarbonPeriodFinderTest extends TestCase
{
    public function test_finds_no_periods_when_none_are_low()
    {
        $forecast = [
            '2025-06-18T06:00Z' => ['intensity' => 100, 'band' => 'moderate'],
            '2025-06-18T06:30Z' => ['intensity' => 90, 'band' => 'moderate'],
            '2025-06-18T07:00Z' => ['intensity' => 80, 'band' => 'moderate'],
        ];
        $result = LowCarbonPeriodFinder::findLowPeriods($forecast);
        $this->assertEmpty($result);
    }

    public function test_finds_single_low_period()
    {
        $forecast = [
            '2025-06-18T06:00Z' => ['intensity' => 50, 'band' => 'low'],
            '2025-06-18T06:30Z' => ['intensity' => 40, 'band' => 'very low'],
            '2025-06-18T07:00Z' => ['intensity' => 30, 'band' => 'low'],
            '2025-06-18T07:30Z' => ['intensity' => 20, 'band' => 'very low'],
            '2025-06-18T08:00Z' => ['intensity' => 10, 'band' => 'low'],
            '2025-06-18T08:30Z' => ['intensity' => 5, 'band' => 'very low'],
        ];
        $result = LowCarbonPeriodFinder::findLowPeriods($forecast);
        $this->assertEquals([
            ['start' => '2025-06-18T06:00Z', 'end' => '2025-06-18T08:30Z'],
        ], $result);
    }

    public function test_finds_multiple_low_periods()
    {
        $forecast = [
            // First valid period (6 increments)
            '2025-06-18T06:00Z' => ['intensity' => 50, 'band' => 'low'],
            '2025-06-18T06:30Z' => ['intensity' => 40, 'band' => 'very low'],
            '2025-06-18T07:00Z' => ['intensity' => 30, 'band' => 'low'],
            '2025-06-18T07:30Z' => ['intensity' => 20, 'band' => 'very low'],
            '2025-06-18T08:00Z' => ['intensity' => 10, 'band' => 'low'],
            '2025-06-18T08:30Z' => ['intensity' => 5, 'band' => 'very low'],
            // Break (not low/very low)
            '2025-06-18T09:00Z' => ['intensity' => 4, 'band' => 'moderate'],
            // Second valid period (6 increments)
            '2025-06-18T09:30Z' => ['intensity' => 3, 'band' => 'low'],
            '2025-06-18T10:00Z' => ['intensity' => 2, 'band' => 'very low'],
            '2025-06-18T10:30Z' => ['intensity' => 1, 'band' => 'low'],
            '2025-06-18T11:00Z' => ['intensity' => 0, 'band' => 'very low'],
            '2025-06-18T11:30Z' => ['intensity' => 0, 'band' => 'low'],
            '2025-06-18T12:00Z' => ['intensity' => 0, 'band' => 'very low'],
        ];
        $result = LowCarbonPeriodFinder::findLowPeriods($forecast);
        $this->assertEquals([
            ['start' => '2025-06-18T06:00Z', 'end' => '2025-06-18T08:30Z'],
            ['start' => '2025-06-18T09:30Z', 'end' => '2025-06-18T12:00Z'],
        ], $result);
    }

    public function test_finds_single_4_hour_low_period()
    {
        $forecast = [
            '2025-06-18T05:30Z' => ['intensity' => 10, 'band' => 'moderate'],
            '2025-06-18T06:00Z' => ['intensity' => 50, 'band' => 'low'],
            '2025-06-18T06:30Z' => ['intensity' => 40, 'band' => 'very low'],
            '2025-06-18T07:00Z' => ['intensity' => 30, 'band' => 'low'],
            '2025-06-18T07:30Z' => ['intensity' => 20, 'band' => 'very low'],
            '2025-06-18T08:00Z' => ['intensity' => 10, 'band' => 'low'],
            '2025-06-18T08:30Z' => ['intensity' => 5, 'band' => 'very low'],
            '2025-06-18T09:00Z' => ['intensity' => 4, 'band' => 'low'],
            '2025-06-18T09:30Z' => ['intensity' => 3, 'band' => 'very low'],
            '2025-06-18T10:00Z' => ['intensity' => 10, 'band' => 'moderate'],
        ];
        $result = LowCarbonPeriodFinder::findLowPeriods($forecast);
        $this->assertEquals([
            ['start' => '2025-06-18T06:00Z', 'end' => '2025-06-18T09:30Z'],
        ], $result);
    }
}
