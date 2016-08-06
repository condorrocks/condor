<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
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

    /**
     * We need to replace the ConfigureLogging bootstrappers to use the custom
     * one. We’ll do this by overriding their respective constructors and
     * doing an array_walk to the bootstrappers property.
     *
     * @param Application $app
     * @param Router      $router
     */
    public function __construct(Application $app, Dispatcher $events)
    {
        parent::__construct($app, $events);

        array_walk($this->bootstrappers, function (&$bootstrapper) {
            if ($bootstrapper === \Illuminate\Foundation\Bootstrap\ConfigureLogging::class) {
                $bootstrapper = \App\Bootstrap\ConfigureLogging::class;
            }
        });
    }
}
