<?php

namespace App\Console\Commands;

use App\Aspect;
use App\Board;
use App\Condor\Aspects\Uptime\UptimeFeed;
use App\Snapshot;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        $boards = Board::all();

        $this->processBoards($boards);
    }

    protected function processBoards($boards)
    {
        foreach ($boards as $board) {
            $this->processFeeds($board, $board->feeds);
        }
    }

    protected function processFeeds($board, $feeds)
    {
        foreach ($feeds as $feed) {
            $uptimefeed = new UptimeFeed($feed->apikey);
            $snapshotData = $uptimefeed->run()->snapshot();

            $snapshot = Snapshot::updateOrCreate([
                'board_id'  => $board->id,
                'aspect_id' => Aspect::whereName('uptime')->first()->id,
                'hash'      => md5("{$feed->name}/{$feed->apikey}"),
                ], [
                'timestamp' => Carbon::now(),
                'target'    => $feed->name,
                'data'      => json_encode($snapshotData),
                ]);
        }
    }
}
