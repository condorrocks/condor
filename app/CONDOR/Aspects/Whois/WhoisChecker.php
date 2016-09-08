<?php

namespace App\Condor\Aspects\Whois;

use App\Condor\Checker;

class WhoisChecker extends Checker
{
    public function status()
    {
        return parent::STATUS_OK; // mock
    }

    public function lookForIssues()
    {
        // mock
    }
}
