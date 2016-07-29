<?php

namespace App\Http\Controllers\Manage;

use App\Board;
use App\Http\Controllers\Controller;
use App\Jobs\PurgeSnapshots;
use Illuminate\Http\Request;

class SnapshotController extends Controller
{
    /**
     * Purge all snapshots from Board.
     *
     * @param Board $board
     *
     * @return Response
     */
    public function purge(Board $board)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('boardId:%s', $board->id));

        $this->authorize('manage', $board);

        // BEGIN

        $this->dispatch(new PurgeSnapshots($board));

        return view('manage.boards.show', compact('board'));
    }
}
