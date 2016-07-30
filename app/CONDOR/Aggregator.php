<?php

namespace App\Condor;

interface Aggregator
{
    public function summarize();

    public function getSnapshot();
}
