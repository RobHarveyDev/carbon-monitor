<?php

declare(strict_types=1);

namespace Feature\API\Intensity;

use App\Enums\IntensityIndex;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Tests\TestCase;

class CurrentIntensityTest extends TestCase
{
    use RefreshDatabase;

    public function test_intensity_now_returns_expected_response()
    {
        // Mock the Saloon API response
        $mockApiResponse = [
            'data' => [
                [
                    'from' => '2025-06-20T10:00Z',
                    'to' => '2025-06-20T10:30Z',
                    'intensity' => [
                        'actual' => 120,
                        'forecast' => 130,
                        'index' => 'moderate',
                    ],
                ],
            ],
        ];

        // Use Saloon's own response faking
        Saloon::fake([
            'https://api.carbonintensity.org.uk/intensity' => MockResponse::make(body: $mockApiResponse, status: 200),
        ]);

        $response = $this->getJson('/api/intensity/now');

        $response->assertOk();
        $response->assertJson([
            'periodFrom' => '2025-06-20T10:00:00Z',
            'periodTo' => '2025-06-20T10:30:00Z',
            'actualIntensity' => 120,
            'forecastIntensity' => 130,
            'actualBand' => IntensityIndex::MODERATE->value,
        ]);
    }
}
