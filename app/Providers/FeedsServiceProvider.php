<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FeedsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('UptimeRobot', function ($app) {
            return new \Alariva\UptimeRobot\UptimeRobot();
        });
    }
}
