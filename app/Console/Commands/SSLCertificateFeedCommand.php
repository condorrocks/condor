<?php

namespace App\Console\Commands;

use App\Aspect;
use App\Board;
use App\Condor\Aspects\SSLCertificate\SSLCertificateFeed;
use App\Snapshot;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SSLCertificateFeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sslcertificate:feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Feed SSLCertificate';

    protected $aspect_id;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->init();
    }

    protected function init()
    {
        $this->aspect_id = Aspect::whereName('sslcertificate')->first()->id;
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
            $this->processFeeds($board, $board->feeds()->forAspect($this->aspect_id)->get());
        }
    }

    protected function processFeeds($board, $feeds)
    {
        foreach ($feeds as $feed) {
            $this->info("BOARD:{$board->id} ASPECT:{$this->aspect_id} FEED:{$feed->name}");

            $sslcertificate = new SSLCertificateFeed($feed->params);
            $snapshotData = $sslcertificate->run()->snapshot();

            $snapshot = Snapshot::updateOrCreate([
                'board_id'  => $board->id,
                'aspect_id' => $this->aspect_id,
                'hash'      => md5("{$board->id}/{$this->aspect_id}/{$feed->name}"),
                ], [
                'timestamp' => Carbon::now(),
                'target'    => $feed->name,
                'data'      => json_encode($snapshotData),
                ]);
        }
    }
}
