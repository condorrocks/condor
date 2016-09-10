<?php

namespace App\Condor\Aspects\SSLCertificate;

use App\Condor\Checker;

class SSLCertificateChecker extends Checker
{
    public function status()
    {
        if ($this->checkExpired()) {
            return parent::STATUS_NOK;
        }

        return parent::STATUS_OK;
    }

    public function lookForIssues()
    {
        if ($this->checkExpired()) {
            $this->addIssue('SSL Certificate is expired');
        }
    }

    protected function checkExpired()
    {
        return (int) $this->snapshot->data('expiresInDays') <= 0;
    }
}
