<?php

namespace App\Condor;

abstract class Aggregator
{
    protected $summary = null;

    protected $snapshots = null;

    public function __construct($snapshots)
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

    abstract public function summarize();
}
