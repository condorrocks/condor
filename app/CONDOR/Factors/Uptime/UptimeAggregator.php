<?php

namespace App\Condor\Factors\Uptime;

class UptimeAggregator
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
            return ($item->status == 2) && $carry;
        }, true);

        return $this;
    }

    public function snapshot()
    {
        return [
            'online' => $this->online,
            'snapshots' => $this->snapshots->toArray(),
            ];
    }
}
