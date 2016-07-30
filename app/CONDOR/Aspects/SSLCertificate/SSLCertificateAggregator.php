<?php

namespace App\Condor\Aspects\SSLCertificate;

use App\Condor\Aggregator;

class SSLCertificateAggregator implements Aggregator
{
    private $snapshots;

    protected $online = false;

    public function __construct($snapshots)
    {
        $this->snapshots = $snapshots;
    }

    public function summarize()
    {
        $this->online = $this->snapshots->reduce(function ($carry, $item) {
            $data = json_decode($item->data);

            return ($data->expiresInDays > 0) && $carry;
        }, true);

        return $this;
    }

    public function getSnapshot()
    {
        return [
            'label'     => $this->statusLabel($this->online),
            'online'    => $this->online,
            'snapshots' => $this->snapshots->toArray(),
            ];
    }

    protected function statusLabel($isOnline)
    {
        return $isOnline ? 'success' : 'danger';
    }
}
