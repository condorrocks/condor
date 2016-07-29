<?php

namespace App\Jobs;

use App\Board;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurgeSnapshots extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Board
     */
    protected $board;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger()->info(__METHOD__);
        logger()->info("Purging snapshots from board:{$this->board->name}");

        $this->board->snapshots()->forceDelete();
    }
}
