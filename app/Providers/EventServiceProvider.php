<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\NewUserWasRegistered::class => [
            \App\Listeners\AutoSetupUserAccount::class,
        ],
        \App\Events\SnapshotWasUpdated::class => [
            \App\Listeners\CheckSnapshot::class,  
        ],
        \App\Events\SnapshotStatusChanged::class => [
            \App\Listeners\SendSnapshotChangeNotification::class,  
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        \App\Listeners\UserEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
