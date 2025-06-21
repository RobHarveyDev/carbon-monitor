<?php

namespace Feature\API\Intensity;

use App\Enums\IntensityIndex;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Tests\TestCase;

class IntensityForecastTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_forecast_data_from_the_api()
    {
        // Arrange: Fake the Saloon request
        Carbon::setTestNow('2025-06-20 00:00:00');
        $mockData = [
            'data' => [
                [
                    'from' => '2025-06-20T00:00Z',
                    'to' => '2025-06-20T00:30Z',
                    'intensity' => [
                        'forecast' => 120,
                        'actual' => null,
                        'index' => 'moderate',
                    ],
                ],
                [
                    'from' => '2025-06-20T00:30Z',
                    'to' => '2025-06-20T01:00Z',
                    'intensity' => [
                        'forecast' => 110,
                        'actual' => null,
                        'index' => 'low',
                    ],
                ],
            ],
        ];

        Saloon::fake([
            'https://api.carbonintensity.org.uk/intensity/2025-06-20T00:00Z/fw48h' => MockResponse::make($mockData, 200),
        ]);

        // Act: Call the API endpoint
        $response = $this->getJson('/api/intensity/forecast');

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                [
                    'periodFrom' => '2025-06-20T00:00:00Z',
                    'periodTo' => '2025-06-20T00:30:00Z',
                    'actualIntensity' => null,
                    'forecastIntensity' => 120,
                    'intensityIndex' => IntensityIndex::MODERATE->value,
                ],
                [
                    'periodFrom' => '2025-06-20T00:30:00Z',
                    'periodTo' => '2025-06-20T01:00:00Z',
                    'actualIntensity' => null,
                    'forecastIntensity' => 110,
                    'intensityIndex' => IntensityIndex::LOW->value,
                ],
            ]);
    }
}
