<?php

namespace App\Http\Controllers\Manage;

use App\Board;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        logger()->info(__METHOD__);

        // BEGIN
        $accounts = auth()->user()->accounts()->with('boards')->get();

        return view('manage.boards.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        logger()->info(__METHOD__);

        // BEGIN

        $board = new Board(); // For Form Model Binding

        $accounts = $this->listAccounts();

        return view('manage.boards.create', compact('accounts', 'board'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        logger()->info(__METHOD__);

        // BEGIN

        $account = auth()->user()->accounts()->findOrFail($request->get('account_id'));

        $this->authorize('manage', $account);

        $board = Board::firstOrNew($request->only('name'));

        $account->boards()->save($board);

        logger()->info("Stored boardId:{$board->id} into accountId:{$account->id}");

        // flash()->success(trans('manager.service.msg.store.success'));

        return redirect()->route('manage.boards.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Board $board
     *
     * @return Response
     */
    public function show(Board $board)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('boardId:%s', $board->id));

        $this->authorize('manage', $board);

        // BEGIN

        return view('manage.boards.show', compact('board'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Board $board
     *
     * @return Response
     */
    public function edit(Board $board)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('board:%s', $board->id));

        $this->authorize('manage', $board);

        // BEGIN

        $accounts = $this->listAccounts();

        return view('manage.boards.edit', compact('accounts', 'board'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Board $board
     *
     * @return Response
     */
    public function update(Board $board, Request $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('boardId:%s', $board->id));

        $this->authorize('manage', $board);

        // BEGIN

        $board->accounts()->sync([$request->get('account_id')]);

        $board->update($request->only([
            'name',
        ]));

        // flash()->success(trans('manage.boards.msg.update.success'));

        return redirect()->route('manage.boards.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Board $board
     *
     * @return Response
     */
    public function destroy(Board $board)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('boardId:%s', $board->id));

        $this->authorize('manage', $board);

        // BEGIN

        $board->forceDelete();

        // flash()->success(trans('manager.services.msg.destroy.success'));

        return redirect()->route('manage.boards.index');
    }

    protected function listAccounts()
    {
        return auth()->user()->accounts->pluck('name', 'id');
    }
}
