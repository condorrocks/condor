<?php

namespace App\Condor\Aspects\Uptime;

use Alariva\UptimeRobot\UptimeRobot;
use App\Condor\Feeder;

class UptimeFeed extends Feeder
{
    private $feed;

    protected $snapshot;

    public function __construct($apikey)
    {
        $this->feed = app()->make('UptimeRobot');
        $this->feed->configure($apikey, 1);
    }

    public function getSnapshot()
    {
        return $this->snapshots->first();
    }

    public function feed()
    {
        $this->feed->setFormat('json'); //Define the format of responses (json or xml)

        $this->feed = $this->feed->getMonitors(0000);

        $collection = collect($this->feed->monitors->monitor);

        $this->snapshots = $collection;
    }
}
