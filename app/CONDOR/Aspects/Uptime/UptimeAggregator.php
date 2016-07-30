<?php

namespace App\Condor\Aspects\Uptime;

use App\Condor\Aggregator;

class UptimeAggregator implements Aggregator
{
    private $snapshot = null;

    private $snapshots = null;

    protected $online = false;

    public function __construct($snapshots)
    {
        $this->snapshots = $snapshots;
    }

    public function summarize()
    {
        $this->online = $this->snapshots->reduce(function ($carry, $item) {
            $data = json_decode($item->data);

            return ($data->status == 2) && $carry;
        }, true);

        return $this;
    }

    public function getSnapshot()
    {
        if ($this->snapshot === null) {
            $this->summarize()->build();
        }

        return $this->snapshot;
    }

    protected function build()
    {
        $this->snapshot = [
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
