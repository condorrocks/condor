<?php

use Carbon\Carbon;
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

    protected $sslSnapshot;

    protected $uptimeSnapshot;

    /**
     * @test
     */
    public function it_presents_the_dashboard()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->visit('/home');

        $this->seePageIs('/home');
        $this->see($this->uptimeSnapshot->target);
        $this->see($this->sslSnapshot->target);
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

        $this->uptimeSnapshot = $this->createSnapshot([
            'aspect_id' => App\Aspect::whereName('uptime')->first()->id,
            'target'    => 'example-target-uptime',
            'data'      => json_encode([
                'status'             => 2,
                'alltimeuptimeratio' => '99.99',
                ]),
            ]);

        $this->board->snapshots()->save($this->uptimeSnapshot);

        $this->sslSnapshot = $this->createSnapshot([
            'aspect_id' => App\Aspect::whereName('sslcertificate')->first()->id,
            'target'    => 'example-target-ssl',
            'data'      => json_encode([
                'url'           => 'https://condor.rocks',
                'expiresInDays' => 3,
                'expires'       => Carbon::parse(date('Y-m-d 08:00:00', strtotime('today +3 days'))),
                'status'        => true,
                'domain'        => 'condor.rocks',
                ]),
            ]);

        $this->board->snapshots()->save($this->sslSnapshot);
    }
}
