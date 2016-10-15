<?php

namespace App\Presenters;

use App\Condor\Checker;
use App\Snapshot;
use McCool\LaravelAutoPresenter\BasePresenter;

class SnapshotPresenter extends BasePresenter
{
    public function __construct(Snapshot $resource)
    {
        $this->wrappedObject = $resource;
    }

    public function cssStatus()
    {
        switch ($this->wrappedObject->status) {
            case Checker::STATUS_OK:
                return 'success';
            case Checker::STATUS_NOK:
                return 'danger';
            case Checker::STATUS_WARN:
                return 'warning';
            default:
                return 'default';
                break;
        }
    }

    public function timestamp()
    {
        return $this->wrappedObject->timestamp->toDateTimeString();
    }

    public function aspect()
    {
        return $this->wrappedObject->aspect->name;
    }
}
