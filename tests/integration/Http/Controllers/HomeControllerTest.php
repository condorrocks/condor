<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class HomeControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateUser, CreateAccount, CreateBoard, CreateSnapshot;

    protected $user;

    protected $account;

    protected $board;

    protected $snapshot;

    /**
     * @test
     */
    public function it_presents_the_dashboard()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->visit('/home');

        $this->seePageIs('/home');
        $this->see($this->snapshot->target);
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

        $aspect = App\Aspect::whereName('uptime')->first();

        $this->snapshot = $this->createSnapshot([
            'aspect_id' => $aspect->id,
            'target'    => 'example-target',
            'data'      => json_encode(['status' => 2, 'alltimeuptimeratio' => '99.99']),
            ]);

        $this->board->snapshots()->save($this->snapshot);
    }
}
