<?php

namespace App\Condor\Aspects\SSLCertificate;

use EricMakesStuff\ServerMonitor\Monitors\SSLCertificateMonitor;

class SSLCertificateMonitorAdapter
{
    public function runMonitor(array $config)
    {
        $monitor = new SSLCertificateMonitor($config);

        $monitor->runMonitor();

        return $monitor;
    }
}
