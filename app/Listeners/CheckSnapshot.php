<?php

namespace App\Listeners;

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
        $snapshot = $event->snapshot;

        $aspect = $snapshot->aspect;

        $checker = $this->createCheckerObject($aspect->name, $snapshot);

        $checker->lookForIssues();

        $issues = $checker->issues();

        logger()->debug(serialize($issues));
    }

    /**
     * Create a chcker Object.
     *
     * @param  string $aspectName
     * @param  \App\Snapshot   $snapshot
     *
     * @return void
     */
    protected function createCheckerObject($aspectName, Snapshot $snapshot)
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
