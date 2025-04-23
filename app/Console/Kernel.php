<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:asset-reminder')->dailyAt('10:30');
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}