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

    protected function init()
    {
        $this->aspect_id = Aspect::whereName('uptime')->first()->id;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->init();

        $boards = Board::all();

        $this->info('Feeding uptime...');
        logger()->info('PROCESS Feeding uptime...');

        $this->processBoards($boards);

        $this->info('Finished...');
        logger()->info('PROCESS Feeding uptime...');
    }

    protected function processBoards($boards)
    {
        foreach ($boards as $board) {
            $this->processFeeds($board, $board->feeds()->forAspect($this->aspect_id)->get());
        }
    }

    protected function processFeeds($board, $feeds)
    {
        foreach ($feeds as $feed) {
            $this->info("BOARD:{$board->id} ASPECT:{$this->aspect_id} FEED:{$feed->name}");
            logger()->info("PROCESS BOARD:{$board->id} ASPECT:{$this->aspect_id} FEED:{$feed->name}");

            try {
                $uptimefeed = new UptimeFeed($feed->apikey);
                $snapshotData = $uptimefeed->run()->getSnapshot();
            } catch (\Exception $e) {
                logger()->error($e->getMessage());
                continue;
            }

            Snapshot::updateOrCreate([
                'board_id'  => $board->id,
                'aspect_id' => $this->aspect_id,
                'hash'      => md5("{$board->id}/{$this->aspect_id}/{$feed->name}/{$feed->apikey}"),
                ], [
                'timestamp' => Carbon::now(),
                'target'    => $feed->name,
                'data'      => json_encode($snapshotData),
                ]);
        }
    }
}
