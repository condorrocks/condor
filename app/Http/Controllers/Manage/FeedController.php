<?php

namespace App\Http\Controllers\Manage;

use App\Aspect;
use App\Board;
use App\Feed;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  Board $board
     *
     * @return Response
     */
    public function create(Board $board)
    {
        logger()->info(__METHOD__);

        $this->authorize('manage', $board);

        // BEGIN

        $feed = new Feed(); // For Form Model Binding

        $aspects = $this->listAspects();

        return view('manage.feeds.create', compact('board', 'feed', 'aspects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        logger()->info(__METHOD__);

        $board = Board::findOrFail($request->get('board_id'));

        $this->authorize('manage', $board);

        // BEGIN

        $feed = Feed::create($request->all());

        $board->feeds()->save($feed);

        logger()->info("Stored feedId:{$feed->id} into boardId:{$board->id}");

        flash()->success(trans('manage.feed.msg.store.success'));

        return redirect()->route('manage.boards.show', compact('board'));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param Board $board
//     *
//     * @return Response
//     */
//    public function show(Board $board)
//    {
//        logger()->info(__METHOD__);
//        logger()->info(sprintf('boardId:%s', $board->id));
//
//        $this->authorize('manage', $board);
//
//        // BEGIN
//
//        return view('manage.boards.show', compact('board'));
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Feed $feed
     * @param Board $board
     *
     * @return Response
     */
    public function edit(Feed $feed, Board $board)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('feed:%s', $feed->id));

        $this->authorize('manage', [$feed, $board]);

        // BEGIN

        $aspects = $this->listAspects();

        return view('manage.feeds.edit', compact('aspects', 'feed', 'board'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Feed $feed
     * @param Request $request
     *
     * @return Response
     */
    public function update(Feed $feed, Request $request)
    {
        logger()->info(__METHOD__);

        $board = Board::findOrFail($request->get('board_id'));

        logger()->info(sprintf('feedId:%s boardId:%s', $feed->id, $board->id));

        $this->authorize('manage', [$feed, $board]);

        // BEGIN

        $feed->update($request->all());

        flash()->success(trans('manage.feed.msg.update.success'));

        return redirect()->route('manage.boards.show', compact('board'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Feed $feed
     *
     * @return Response
     */
    public function destroy(Feed $feed, Board $board)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('feedId:%s', $feed->id));

        $this->authorize('manage', [$feed, $board]);

        // BEGIN

        $feed->forceDelete();

        flash()->success(trans('manage.feed.msg.destroy.success'));

        return redirect()->route('manage.boards.index');
    }

    protected function listAspects()
    {
        return Aspect::all()->pluck('name', 'id');
    }
}
