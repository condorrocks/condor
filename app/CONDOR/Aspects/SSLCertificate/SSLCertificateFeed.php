<?php

namespace App\Condor\Aspects\SSLCertificate;

use EricMakesStuff\ServerMonitor\Monitors\SSLCertificateMonitor;

class SSLCertificateFeed
{
    private $feed;

    protected $snapshot;

    public function __construct($params)
    {
        $this->params = json_decode($params);
    }

    public function snapshot()
    {
        return $this->snapshot;
    }

    public function run()
    {
        $url = $this->params->url;

        $monitor = new SSLCertificateMonitor([
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
