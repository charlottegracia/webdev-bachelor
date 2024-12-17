<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ExpireIncidents;
use App\Console\Commands\DemoCron;

class Kernel extends ConsoleKernel
{
    /**
     * Register commands.
     */
    protected $commands = [
        ExpireIncidents::class,
        DemoCron::class,
    ];

    /**
     * Define the application's scheduled tasks.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('demo:cron')->everyMinute();
        
        $schedule->command('expire:incidents')->everyMinute();
    }

    /**
     * Register scheduling commands.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}