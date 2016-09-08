<?php

namespace App\Condor\Aspects\SSLCertificate;

use App\Condor\Checker;

class SSLCertificateChecker extends Checker
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
