<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageSnapshotControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateAccount, CreateBoard, CreateSnapshot;

    /**
     * @var App\User
     */
    protected $user;

    /**
     * @var App\Account
     */
    protected $account;

    /**
     * @var App\Board
     */
    protected $board;

    /**
     * @var App\Snapshot
     */
    protected $snapshot;

    /** @test */
    public function it_purges_snapshots_from_board()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->seeInDatabase('snapshots', ['target' => $this->snapshot->target]);

        $this->visit(route('manage.boards.purge', $this->board));

        $this->dontSeeInDatabase('snapshots', ['target' => $this->snapshot->target]);
    }

    //////////////////////
    // Scenario Helpers //
    //////////////////////

    protected function scenario()
    {
        $this->user = $this->createUser();

        $this->account = $this->createAccount();

        $this->user->accounts()->save($this->account);

        $this->board = $this->createBoard();

        $this->account->boards()->save($this->board);

        $this->snapshot = $this->createSnapshot();

        $this->board->snapshots()->save($this->snapshot);
    }
}
