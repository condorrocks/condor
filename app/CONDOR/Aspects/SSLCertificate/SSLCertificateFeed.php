<?php

namespace App\Condor\Aspects\SSLCertificate;

use App\Condor\Feeder;

class SSLCertificateFeed extends Feeder
{
    private $feed;

    protected $snapshot = null;

    public function __construct($params)
    {
        $this->params = json_decode($params);
    }

    public function getSnapshot()
    {
        return $this->snapshot;
    }

    public function feed()
    {
        $url = $this->params->url;

        $monitorAdapter = app()->make('SSLCertificateMonitorAdapter');

        $monitor = $monitorAdapter->runMonitor([
            'url' => $url,
        ]);

        $expiresInDays = $monitor->getCertificateDaysUntilExpiration();

        $expires = $monitor->getCertificateExpiration();

        $domain = $monitor->getCertificateDomain();

        $status = $expiresInDays > 0;

        $this->snapshot = compact('url', 'expiresInDays', 'expires', 'domain', 'status');

        return $this;
    }
}
