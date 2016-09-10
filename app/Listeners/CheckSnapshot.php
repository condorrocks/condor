<?php

namespace App\Listeners;

use App\Events\SnapshotStatusChanged;
use App\Events\SnapshotWasUpdated;
use App\Snapshot;

class CheckSnapshot
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
     * @param  SnapshotWasUpdated  $event
     *
     * @return void
     */
    public function handle(SnapshotWasUpdated $event)
    {
        $checker = $this->getChecker($event->snapshot->aspect->name, $event->snapshot);

        $issues = $checker->lookForIssues();

        if ($event->snapshot->status != $checker->status()) {
            $event->snapshot->last_status = $event->snapshot->status;

            $event->snapshot->status = $checker->status();

            $event->snapshot->save();

            event(new SnapshotStatusChanged($event->snapshot, $issues));
        }
    }

    /**
     * Get a checker Object.
     *
     * @param  string $aspectName
     * @param  \App\Snapshot   $snapshot
     *
     * @return void
     */
    protected function getChecker($aspectName, Snapshot $snapshot)
    {
        switch ($aspectName) {
            case 'whois':
                return new \App\Condor\Aspects\Whois\WhoisChecker($snapshot);
            case 'sslcertificate':
                return new \App\Condor\Aspects\SSLCertificate\SSLCertificateChecker($snapshot);
            case 'uptime':
                return new \App\Condor\Aspects\Uptime\UptimeChecker($snapshot);
            default:
                throw new \Exception("Unidentified aspect name:{$aspectName}", 1);
        }
    }
}
