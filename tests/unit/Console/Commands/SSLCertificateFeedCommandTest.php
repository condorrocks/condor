<?php

use App\Aspect;
use Carbon\Carbon;
use Symfony\Component\Console\Tester\CommandTester;

class SSLCertificateFeedCommandTest extends FeedCommandTest
{
    use CreateUser, CreateAccount, CreateBoard, CreateFeed;

    /** @test */
    public function it_runs_sslcertificate_feeds()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'aspect'  => 'sslcertificate',
        ]);

        $this->assertRegExp('/Feeding aspect sslcertificate/', $this->commandTester->getDisplay());
    }

    protected function scenario()
    {
        $user = $this->createUser();

        $account = $this->createAccount();

        $user->accounts()->save($account);

        $board = $this->createBoard();

        $account->boards()->save($board);

        $aspect = Aspect::whereName('sslcertificate')->first();

        $feed = $this->createFeed([
            'aspect_id' => $aspect->id,
            'name'      => 'Condor SSL Certificate',
            'apikey'    => '', // Dummy API Key
            'params'    => json_encode(['url' => 'https://condor.rocks']),
            ]);

        $board->feeds()->save($feed);
    }

    protected function mockAPI()
    {
        $this->app->bind('SSLCertificateMonitor', function () {
            $mock = Mockery::mock(EricMakesStuff\ServerMonitor\Monitors\SSLCertificateMonitor::class)->makePartial();

            $mock->shouldReceive('runMonitor')->once();

            $mock->shouldReceive('getCertificateDaysUntilExpiration')->once()->andReturn(3);

            $mock->shouldReceive('getCertificateExpiration')->once()->andReturn(Carbon::parse('today +3 days')->toDateString());

            $mock->shouldReceive('getCertificateDomain')->once()->andReturn('condor.rocks');

            return $mock;
        });
    }
}
