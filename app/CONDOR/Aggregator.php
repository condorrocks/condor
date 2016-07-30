<?php

namespace App\Condor;

use Illuminate\Support\Collection;

abstract class Aggregator
{
    protected $summary = null;

    protected $snapshots = null;

    protected $online = false;

    public function __construct(Collection $snapshots)
    {
        $this->snapshots = $snapshots;
    }

    public function getSummary()
    {
        if ($this->summary === null) {
            $this->summarize()->build();
        }

        return $this->summary;
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

    abstract public function summarize();

    abstract protected function statusLabel($status);
}
