<?php

namespace Feature\API\Intensity;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Tests\TestCase;

class IntensityGenerationNowTest extends TestCase
{
    use RefreshDatabase;

    public function test_intensity_generation_now_endpoint_returns_expected_response()
    {
        // Arrange: Mock the third-party response
        $mockResponse = [
            'data' => [
                [
                    'from' => '2025-06-20T00:00Z',
                    'to' => '2025-06-20T00:30Z',
                    'generationmix' => [
                        ['fuel' => 'gas', 'perc' => 40.5],
                        ['fuel' => 'nuclear', 'perc' => 19.5],
                        ['fuel' => 'wind', 'perc' => 25.0],
                        ['fuel' => 'solar', 'perc' => 15.0],
                    ],
                ],
            ],
        ];
        Saloon::fake([
            'https://api.carbonintensity.org.uk/generation' => MockResponse::make($mockResponse, 200),
        ]);

        // Act: Call the endpoint
        $response = $this->getJson('/api/intensity/generation/now');

        // Assert: Check the response structure and data
        $response->assertStatus(200)
            ->assertJson([
                ['fuelType' => 'Gas', 'percentage' => 40.5],
                ['fuelType' => 'Nuclear', 'percentage' => 19.5],
                ['fuelType' => 'Wind', 'percentage' => 25],
                ['fuelType' => 'Solar', 'percentage' => 15],
            ]);
    }
}
