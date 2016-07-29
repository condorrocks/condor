<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Condor Aggregators
    |--------------------------------------------------------------------------
    |
    | This file is for mapping the aggregation services with the associated
    | class.
    |
    */

    'uptime'         => App\Condor\Aspects\Uptime\UptimeAggregator::class,
    'sslcertificate' => App\Condor\Aspects\SSLCertificate\SSLCertificateAggregator::class,

];
