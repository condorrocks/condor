<?php

namespace App\Condor\Aspects\Whois;

use App\Condor\Checker;

class WhoisChecker extends Checker
{
    public function status()
    {
        if (!$this->checkRegistered()) {
            return parent::STATUS_NOK;
        }

        return parent::STATUS_OK; // mock
    }

    public function lookForIssues()
    {
        if (!$this->checkRegistered()) {
            $this->addIssue('Domain is not registered');
        }

        return $this->issues();
    }

    protected function checkRegistered()
    {
        return (bool) $this->snapshot->data('registered');
    }
}
