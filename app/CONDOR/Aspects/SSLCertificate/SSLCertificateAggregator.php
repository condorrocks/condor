<?php

namespace App\Condor\Aspects\SSLCertificate;

use App\Condor\Aggregator;

class SSLCertificateAggregator extends Aggregator
{
    protected $online = false;

    public function summarize()
    {
        $this->online = $this->snapshots->reduce(function ($carry, $item) {
            $data = json_decode($item->data);

            return ($data->expiresInDays > 0) && $carry;
        }, true);

        return $this;
    }

    protected function build()
    {
        $this->summary = [
            'label'     => $this->statusLabel($this->online),
            'online'    => $this->online,
            'snapshots' => $this->snapshots->toArray(),
            ];

        return $this;
    }

    protected function statusLabel($isOnline)
    {
        return $isOnline ? 'success' : 'danger';
    }
}
