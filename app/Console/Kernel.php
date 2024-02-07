<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    protected function schedule(Schedule $schedule): void {
        $schedule->command('app:check-order-hours')->everySecond();
        $schedule->command('app:check-order-day')->everySecond();
        $schedule->command('app:modified-day-notify')->everySecond();
        $schedule->command('app:modified-hour-notify')->everySecond();
        $schedule->command('app:db-export')->timezone(config('app.timezone'))->dailyAt('12:00')->days([0, 2, 4]);
    }

    protected function commands(): void {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
