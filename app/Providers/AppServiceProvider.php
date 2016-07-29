<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\App\Providers\FeedsServiceProvider::class);

        if ($this->app->environment() == 'local') {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        if (config('services.rollbar.access_token', false)) {
            $this->app->register(\Jenssegers\Rollbar\RollbarServiceProvider::class);
        }
    }
}
