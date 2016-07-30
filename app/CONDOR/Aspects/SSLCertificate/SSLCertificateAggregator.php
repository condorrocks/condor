<?php

namespace App\Condor\Aspects\SSLCertificate;

use App\Condor\Aggregator;

class SSLCertificateAggregator extends Aggregator
{
    public function summarize()
    {
        $this->online = $this->snapshots->reduce(function ($carry, $item) {
            $data = json_decode($item->data);

            return ($data->expiresInDays > 0) && $carry;
        }, true);

        return $this;
    }

    protected function statusLabel($isOnline)
    {
        return $isOnline ? 'success' : 'danger';
    }
}
