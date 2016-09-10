<?php

namespace App\Condor\Aspects\Uptime;

use App\Condor\Checker;
use App\Snapshot;

class UptimeChecker extends Checker
{
    const UPTIMEROBOT_STATUS_PAUSED = 0;
    const UPTIMEROBOT_STATUS_NOT_CHECKED_YET = 1;
    const UPTIMEROBOT_STATUS_UP = 2;
    const UPTIMEROBOT_STATUS_SEEMS_DOWN = 8;
    const UPTIMEROBOT_STATUS_DOWN = 9;

    public function status()
    {
        $externalStatus = $this->snapshot->data('status');

        switch ((int) $externalStatus) {
            case self::UPTIMEROBOT_STATUS_UP:
                return parent::STATUS_OK;
                break;
            case self::UPTIMEROBOT_STATUS_DOWN:
                return parent::STATUS_NOK;
                break;
            default:
                return parent::STATUS_WARN;
                break;
        }
    }

    public function lookForIssues()
    {
        $status = $this->status();

        if ($status === parent::STATUS_NOK) {
            $this->addIssue('Server is down');
        }

        if ($status === parent::STATUS_WARN) {
            $this->addIssue('Server may have problems');
        }
    }
}
