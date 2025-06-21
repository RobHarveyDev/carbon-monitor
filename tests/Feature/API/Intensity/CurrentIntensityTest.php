<?php

declare(strict_types=1);

namespace Feature\API\Intensity;

use App\Enums\IntensityIndex;
use App\Http\Integrations\CarbonIntensity\Requests\GetCurrentGenerationMix;
use App\Http\Integrations\CarbonIntensity\Requests\GetCurrentIntensity;
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
        $mockIntensityApiResponse = [
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

        $mockGenerationApiResponse = [
            'data' => [
                'from' => '2025-06-20T00:00Z',
                'to' => '2025-06-20T00:30Z',
                'generationmix' => [
                    ['fuel' => 'gas', 'perc' => 40.5],
                    ['fuel' => 'nuclear', 'perc' => 19.5],
                    ['fuel' => 'wind', 'perc' => 25.0],
                    ['fuel' => 'solar', 'perc' => 15.0],
                ],
            ],
        ];

        // Use Saloon's own response faking
        Saloon::fake([
            'https://api.carbonintensity.org.uk/intensity' => MockResponse::make(body: $mockIntensityApiResponse, status: 200),
            'https://api.carbonintensity.org.uk/generation' => MockResponse::make(body: $mockGenerationApiResponse, status: 200),
        ]);

        $response = $this->getJson('/api/intensity/now');

        Saloon::assertSentCount(2);
        Saloon::assertSent(GetCurrentIntensity::class);
        Saloon::assertSent(GetCurrentGenerationMix::class);

        $response->assertOk();
        $response->assertJson([
            'carbonIntensity' => 120,
            'intensityIndex' => IntensityIndex::MODERATE->value,
            'generationMix' => [
                ['fuelType' => 'Gas', 'percentage' => 40.5],
                ['fuelType' => 'Nuclear', 'percentage' => 19.5],
                ['fuelType' => 'Wind', 'percentage' => 25],
                ['fuelType' => 'Solar', 'percentage' => 15],
            ],
        ]);
    }
}
