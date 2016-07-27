<?php

namespace App\Condor\Aspects\Uptime;

use Alariva\UptimeRobot\UptimeRobot;

class UptimeFeed
{
    private $feed;

    protected $snapshot;

    public function __construct($apikey)
    {
        UptimeRobot::configure($apikey, 1);
        $this->feed = new UptimeRobot;
    }

    public function snapshot()
    {
        return $this->snapshots->first();
    }

    public function run()
    {
        $this->feed->setFormat('json'); //Define the format of responses (json or xml)

        /*
         * Get status of one monitor by her id
         */
        try {
            $this->feed = $this->feed->getMonitors(0000);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $collection = collect($this->feed->monitors->monitor);

        $this->snapshots = $collection;

        return $this;
    }
}
