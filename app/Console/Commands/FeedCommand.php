<?php

namespace App\Console\Commands;

use App\Aspect;
use App\Board;
use App\Jobs\RunFeed;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:run {aspect} {boards?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a feed for an Aspect';

    /**
     * Create a new command instance.
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
        $aspect = $this->getAspectFromArgument();

        $boards = $this->getBoardsFromArgument();

        $this->info("Feeding aspect {$aspect}");
        logger()->info("PROCESS Feeding {$aspect}...");

        $this->processBoards($aspect, $boards);

        $this->info('Finished');
        logger()->info('Finished');
    }

    /**
     * Process Boards.
     *
     * @param  string $aspect
     * @param  Illuminate\Support\Collection $boards
     *
     * @return void
     */
    protected function processBoards($aspect, Collection $boards)
    {
        foreach ($boards as $board) {
            $this->info("Dispatching feed for board:{$board->id}");
            dispatch(new RunFeed($aspect, $board));
        }
    }

    /**
     * Get Aspect from Argument.
     *
     * @return string
     */
    protected function getAspectFromArgument()
    {
        return $this->argument('aspect');
    }

    /**
     * Get Boards from Argument.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getBoardsFromArgument()
    {
        $boards = $this->argument('boards');

        if ($boards === null) {
            $this->info('Loading all boards...');

            return Board::all();
        }

        if (is_string($boards)) {
            $boardList = explode(',', $boards);
            $this->info('Loading boards:'.implode(',', $boardList));
        }

        return Board::find($boardList);
    }
}
