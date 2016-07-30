<?php

namespace App\Condor\Aspects\SSLCertificate;

use App\Condor\Feeder;
use EricMakesStuff\ServerMonitor\Monitors\SSLCertificateMonitor;

class SSLCertificateFeed implements Feeder
{
    private $feed;

    protected $snapshot;

    public function __construct($params)
    {
        $this->params = json_decode($params);
    }

    public function getSnapshot()
    {
        return $this->snapshot;
    }

    public function run()
    {
        $url = $this->params->url;

        $monitor = app()->make('SSLCertificateMonitor', [
            'url' => $url,
        ]);

        $monitor->runMonitor();

        $expiresInDays = $monitor->getCertificateDaysUntilExpiration();

        $expires = $monitor->getCertificateExpiration();

        $domain = $monitor->getCertificateDomain();

        $status = $expiresInDays > 0;

        $this->snapshot = compact('url', 'expiresInDays', 'expires', 'domain', 'status');

        return $this;
    }
}
