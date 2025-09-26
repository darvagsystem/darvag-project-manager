<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Daily tasks
        $schedule->command('app:cleanup-old-logs')->daily();
        $schedule->command('app:backup-database')->dailyAt('02:00');

        // Weekly tasks
        $schedule->command('app:generate-weekly-reports')->weekly();

        // Monthly tasks
        $schedule->command('app:archive-old-projects')->monthly();

        // Project status updates
        $schedule->command('app:update-project-statuses')->daily();

        // Employee notifications
        $schedule->command('app:send-employee-reminders')->dailyAt('09:00');

        // System maintenance
        $schedule->command('app:cleanup-temp-files')->weekly();

        // Queue monitoring
        $schedule->command('queue:monitor')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
