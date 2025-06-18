<?php

namespace Tests\Feature;

use App\Http\Saloon\DTO\IntensityDataDTO;
use App\Services\CarbonIntensityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class GetDailyLowCarbonPeriodsTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_outputs_no_periods_when_none_found()
    {
        $mockService = Mockery::mock(CarbonIntensityService::class);
        $mockService->shouldReceive('getIntensityToday')->andReturn(new IntensityDataDTO([], [
            '2025-06-18T06:00Z' => ['intensity' => 100, 'band' => 'moderate'],
            '2025-06-18T07:00Z' => ['intensity' => 90, 'band' => 'moderate'],
            '2025-06-18T08:00Z' => ['intensity' => 80, 'band' => 'moderate'],
        ]));
        $this->app->instance(CarbonIntensityService::class, $mockService);

        $this->artisan('intensity:daily-low-periods')
            ->expectsOutput('No 3-hour low/very low carbon periods found for today.')
            ->assertExitCode(0);
    }

    public function test_command_outputs_periods_when_found()
    {
        $mockService = Mockery::mock(CarbonIntensityService::class);
        $mockService->shouldReceive('getIntensityToday')->andReturn(new IntensityDataDTO([], [
            '2025-06-18T06:00Z' => ['intensity' => 50, 'band' => 'low'],
            '2025-06-18T06:30Z' => ['intensity' => 40, 'band' => 'very low'],
            '2025-06-18T07:00Z' => ['intensity' => 30, 'band' => 'low'],
            '2025-06-18T07:30Z' => ['intensity' => 20, 'band' => 'very low'],
            '2025-06-18T08:00Z' => ['intensity' => 10, 'band' => 'low'],
            '2025-06-18T08:30Z' => ['intensity' => 5, 'band' => 'very low'],
        ]));
        $this->app->instance(CarbonIntensityService::class, $mockService);

        $this->artisan('intensity:daily-low-periods')
            ->expectsOutput('3-hour low/very low carbon periods for today:')
            ->expectsOutput('2025-06-18T06:00Z to 2025-06-18T08:30Z')
            ->assertExitCode(0);
    }
}
