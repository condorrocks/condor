<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\UptimeFeedCommand::class,
        \App\Console\Commands\SSLCertificateFeedCommand::class,
        \App\Console\Commands\WhoisFeedCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('uptime:feed')->hourly();

        $schedule->command('sslcertificate:feed')->weekly();

        $schedule->command('whois:feed')->monthly();
    }
}
