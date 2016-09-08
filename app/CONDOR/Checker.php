<?php

namespace App\Condor;

use App\Snapshot;
use Illuminate\Support\Collection;

abstract class Checker
{
    const STATUS_OK = 0;
    const STATUS_NOK = 1;
    const STATUS_WARN = 2;

    /**
     * @var array
     */
    protected $issues = null;

    /**
     * @var \App\Snapshot
     */
    protected $snapshot = null;

    public function __construct(Snapshot $snapshot)
    {
        $this->snapshot = $snapshot;

        $this->issues = new Collection;
    }

    public function issues()
    {
        return $this->issues;
    }

    protected function addIssue($description)
    {
        $this->issues->push($description);
    }

    abstract public function status();

    abstract public function lookForIssues();
}
