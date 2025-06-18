<?php

namespace App\Console\Commands;

use App\Services\CarbonIntensityService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class GetDailyLowCarbonPeriods extends Command
{
    protected $signature = 'intensity:daily-low-periods';

    protected $description = 'Get daily low carbon periods (runs every day at 6am)';

    public function handle(): void
    {
        // Get today's carbon intensity forecast
        /** @var CarbonIntensityService $service */
        $service = App::make(CarbonIntensityService::class);
        $dto = $service->getIntensityToday();
        $forecast = $dto->forecast;

        // Find all 3-hour periods where all bands are 'low' or 'very low'
        $periods = [];
        $datetimes = array_keys($forecast);
        for ($i = 0; $i <= count($datetimes) - 3; $i++) {
            $window = array_slice($datetimes, $i, 3);
            $allLow = true;
            foreach ($window as $dt) {
                $band = $forecast[$dt]['band'] ?? null;
                if (! in_array($band, ['low', 'very low'])) {
                    $allLow = false;
                    break;
                }
            }
            if ($allLow) {
                $periods[] = $window;
            }
        }

        if (empty($periods)) {
            $this->info('No 3-hour low/very low carbon periods found for today.');
        } else {
            $this->info('3-hour low/very low carbon periods for today:');
            foreach ($periods as $window) {
                $this->line(implode(' to ', [$window[0], $window[2]]));
            }
        }
    }
}
