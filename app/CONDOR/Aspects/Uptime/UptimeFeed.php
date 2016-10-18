<?php

namespace App\Condor\Aspects\Uptime;

use Alariva\UptimeRobot\UptimeRobot;
use App\Condor\Feeder;

class UptimeFeed extends Feeder
{
    private $feed;

    protected $snapshot;

    protected $params;

    public function __construct($params)
    {
        $this->params = (array) json_decode($params);

        $this->feed = app()->make('UptimeRobot');

        $apikey = array_get($this->params, 'apikey', config('services.uptimerobot.key'));

        // logger()->debug('Using Apikey:'.$apikey);

        $this->feed->configure($apikey, 1);
    }

    public function getSnapshot()
    {
        return $this->snapshots->first();
    }

    public function feed()
    {
        $this->feed->setFormat('json'); //Define the format of responses (json or xml)

        $this->feed = $this->feed->getMonitors(array_get($this->params, 'monitor_id', 0));

        logger()->info('CAPTURED RESPONSE:'.serialize($this->feed));

        $collection = collect($this->feed->monitors->monitor);

        $this->snapshots = $collection;
    }
}
