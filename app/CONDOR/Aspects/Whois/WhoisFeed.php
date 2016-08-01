<?php

namespace App\Condor\Aspects\Whois;

use App\Condor\Aspects\Whois\WhoisMapper;
use App\Condor\Feeder;
use phpWhois\Whois;

class WhoisFeed extends Feeder
{
    private $feed;

    protected $snapshot;

    /**
     * @var string
     */
    protected $params;

    public function __construct($params)
    {
        $this->params = json_decode($params);

        $this->feed = app()->make('Whois');
    }

    public function getSnapshot()
    {
        return $this->snapshot;
    }

    public function feed()
    {
        $domain = $this->params->domain;

        $this->snapshot = with(new WhoisMapper($this->feed->lookup($domain, false)))->map();
    }
}
