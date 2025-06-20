<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

use App\Enums\IntensityIndex;
use App\Http\Integrations\CarbonIntensity\DTO\CarbonIntensityDTO;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class CarbonIntensityDTOTest extends TestCase
{
    public function test_from_api_response_creates_dto_correctly()
    {
        $data = [
            'from' => '2025-06-20T10:00Z',
            'to' => '2025-06-20T10:30Z',
            'intensity' => [
                'actual' => 120,
                'forecast' => 130,
                'index' => 'moderate',
            ],
        ];

        $dto = CarbonIntensityDTO::fromApiResponse($data);

        $this->assertTrue($dto->periodFrom->eq(Carbon::parse('2025-06-20T10:00Z')));
        $this->assertTrue($dto->periodTo->eq(Carbon::parse('2025-06-20T10:30Z')));
        $this->assertSame(120, $dto->actualIntensity);
        $this->assertSame(130, $dto->forecastIntensity);
        $this->assertSame(IntensityIndex::MODERATE, $dto->actualBand);
    }
}
