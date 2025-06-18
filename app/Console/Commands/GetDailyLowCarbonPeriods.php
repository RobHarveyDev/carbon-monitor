<?php

namespace App\Console\Commands;

use App\Services\CarbonIntensityService;
use App\Services\LowCarbonPeriodFinder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class GetDailyLowCarbonPeriods extends Command
{
    protected $signature = 'intensity:daily-low-periods';

    protected $description = 'Get daily low carbon periods (runs every day at 6am)';

    public function __construct(private CarbonIntensityService $service)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        // Get today's carbon intensity forecast
        $dto = $this->service->getIntensityToday();
        $forecast = $dto->forecast;

        // Use the reusable finder class
        $periods = LowCarbonPeriodFinder::findLowPeriods($forecast);

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
