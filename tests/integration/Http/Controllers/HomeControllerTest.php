<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardControllerTest extends TestCase
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
    protected $sslSnapshot;

    /**
     * @var App\Snapshot
     */
    protected $uptimeSnapshot;

    /**
     * @var App\Snapshot
     */
    protected $whoisSnapshot;

    /** @test */
    public function it_presents_the_dashboard()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->visit(route('dashboard'));

        $this->seePageIs('/dashboard');
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

        $this->whoisSnapshot = $this->createSnapshot([
            'aspect_id' => App\Aspect::whereName('whois')->first()->id,
            'target'    => 'example-target-whois',
            'data'      => json_encode([
                'domain'        => 'condor.rocks',
                'expiry'        => Carbon::parse('now +7 days')->toDateString(),
                'status'        => "clientDeleteProhibited https:\/\/icann.org\/epp#clientDeleteProhibited",
                'owner'         => 'Ariel Vallese',
                'ownerAddress'  => [
                    'street' => [
                        'Street 123', '1Floor',
                    ],
                    'city'    => 'Buenos Aires',
                    'state'   => "N\/A",
                    'pcode'   => '0123',
                    'country' => 'AR',
                ],
                'nss' => [
                    'ns1.afraid.org' => '127.23.197.123',
                    'ns2.afraid.org' => '127.43.71.123',
                    'ns3.afraid.org' => '127.197.18.123',
                    'ns4.afraid.org' => '127.39.97.123', ],
                    'registered' => true,
                ]),
            ]);

        $this->board->snapshots()->save($this->whoisSnapshot);
    }
}
