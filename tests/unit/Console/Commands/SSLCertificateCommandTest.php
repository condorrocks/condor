<?php

use App\Aspect;
use App\Console\Commands\SSLCertificateFeedCommand;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;

class SSLCertificateCommandTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateAccount, CreateBoard, CreateFeed;

    protected $command;

    protected $commandTester;

    public function setUp()
    {
        parent::setUp();

        $this->mockAPI();

        $application = new ConsoleApplication();

        $testedCommand = $this->app->make(SSLCertificateFeedCommand::class);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('sslcertificate:feed');

        $this->commandTester = new CommandTester($this->command);

        $this->scenario();
    }

    /** @test */
    public function it_runs_sslcertificate_feeds()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
        ]);

        $this->assertRegExp('/Feeding sslcertificate/', $this->commandTester->getDisplay());
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
