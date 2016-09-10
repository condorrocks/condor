<?php

namespace App\Listeners;

use App\Events\SnapshotStatusChanged;
use App\Mail\SnapshotStatusChangeAlert;
use Illuminate\Support\Facades\Mail;

class SendSnapshotChangeAlert
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
        logger()->debug("Snapshot Status Changed from:{$event->snapshot->last_status} to:{$event->snapshot->status} hash:{$event->snapshot->hash} issues:{$event->issues->count()}");

        if($event->snapshot->board->alert_to !== null)
        {
            logger()->debug("Sending alert to {$event->snapshot->board->alert_to}");
            Mail::to($event->snapshot->board->alert_to)->send(new SnapshotStatusChangeAlert($event->snapshot));
        }
    }
}
