<?php

namespace App\Condor\Aspects\Whois;

use App\Condor\Aspects\Whois\WhoisMapper;
use App\Condor\Feeder;
use phpWhois\Whois;

class WhoisFeed implements Feeder
{
    private $feed;

    protected $snapshot;

    public function __construct($params)
    {
        $this->params = json_decode($params);

        $this->feed = app()->make('Whois');
    }

    public function getSnapshot()
    {
        return $this->snapshot;
    }

    public function run()
    {
        try {
            $domain = $this->params->domain;

            $this->snapshot = with(new WhoisMapper($this->feed->lookup($domain, false)))->map();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }
}
