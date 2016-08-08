<?php

namespace App\Jobs;

use App\Aspect;
use App\Board;
use App\Feed;
use App\Snapshot;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var \App\Aspect
     */
    protected $aspect;

    /**
     * @var \App\Board
     */
    protected $board;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $feeds;

    /**
     * Create a new job instance.
     */
    public function __construct($aspectName, Board $board)
    {
        $this->board = $board;

        $this->init($aspectName);

        $this->feeds = $board->feeds()->forAspect($this->aspect->id)->get();
    }

    /**
     * Initialize Aspect.
     *
     * @param  string $aspectName
     *
     * @return void
     */
    protected function init($aspectName)
    {
        $this->aspect = Aspect::whereName($aspectName)->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->feeds as $feed) {
            logger()->info("PROCESS BOARD:{$this->board->id} ASPECT:{$this->aspect->id} FEED:{$feed->name}");

            try {
                $snapshotData = with($this->createFeedObject($this->aspect, $feed))->run()->getSnapshot();
            } catch (\Exception $e) {
                logger()->error($e->getMessage());
                continue;
            }

            Snapshot::updateOrCreate([
                'board_id'  => $this->board->id,
                'aspect_id' => $this->aspect->id,
                'feed_id'   => $feed->id,
                ], [
                'hash'      => md5("{$this->board->id}/{$this->aspect->id}/{$feed->id}".time()),
                'timestamp' => Carbon::now(),
                'target'    => $feed->name,
                'data'      => json_encode($snapshotData),
                ]);
        }
    }

    /**
     * Create a feed Object.
     *
     * @param  \App\Aspect $aspect
     * @param  \App\Feed   $feed
     *
     * @return void
     */
    protected function createFeedObject(Aspect $aspect, Feed $feed)
    {
        switch ($aspect->name) {
            case 'whois':
                return new \App\Condor\Aspects\Whois\WhoisFeed($feed->params);
            case 'sslcertificate':
                return new \App\Condor\Aspects\SSLCertificate\SSLCertificateFeed($feed->params);
            case 'uptime':
                return new \App\Condor\Aspects\Uptime\UptimeFeed($feed->apikey);
            default:
                throw new \Exception("Unidentified aspect name:{$aspect->name}", 1);
        }
    }
}
