<?php

namespace App\Listeners;

use App\Events\SnapshotStatusChanged;

class SendSnapshotChangeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SnapshotStatusChanged  $event
     *
     * @return void
     */
    public function handle(SnapshotStatusChanged $event)
    {
        logger()->debug("Snapshot Status Changed to:{$event->newStatus} hash:{$event->snapshot->hash} issues:{$event->issues->count()}");

        
    }
}
