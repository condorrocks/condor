<?php

namespace App\Condor\Aspects\Whois;

use App\Condor\Aggregator;

class WhoisAggregator extends Aggregator
{
    public function summarize()
    {
        $this->online = $this->snapshots->reduce(function ($carry, $item) {
            $data = json_decode($item->data);

            return ($data->registered == true) && $carry;
        }, true);

        return $this;
    }

    protected function statusLabel($isOnline)
    {
        return $isOnline ? 'success' : 'danger';
    }
}
