<?php

namespace App\Console;

use App\Console\Commands\GetDailyLowCarbonPeriods;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(GetDailyLowCarbonPeriods::class)->dailyAt('6:00');
    }
}

