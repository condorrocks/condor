<?php

namespace App\Console\Commands;

use App\Condor\Factors\Uptime\UptimeAggregator;
use App\Condor\Factors\Uptime\UptimeFeed;
use App\Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class UptimeFeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uptime:feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Feed uptime';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $feeds = Feed::all();

        $snapshots = new Collection;
        foreach ($feeds as $feed) {
            $uptimefeed = new UptimeFeed($feed->apikey);
            $snapshots->push($uptimefeed->run()->snapshot());
        }

        $aggregator = new UptimeAggregator($snapshots);
        var_dump($aggregator->summarize()->snapshot());
    }
}
