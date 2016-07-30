<?php

namespace App\Condor\Aspects\Uptime;

use Alariva\UptimeRobot\UptimeRobot;
use App\Condor\Feeder;

class UptimeFeed implements Feeder
{
    private $feed;

    protected $snapshot;

    public function __construct($apikey)
    {
        $this->feed = app()->make('UptimeRobot');
        $this->feed->configure($apikey, 1);
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
