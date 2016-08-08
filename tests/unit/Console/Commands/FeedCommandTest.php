<?php

use App\Console\Commands\FeedCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;

abstract class FeedCommandTest extends TestCase
{
    use DatabaseTransactions;

    protected $command;

    protected $commandTester;

    public function setUp()
    {
        parent::setUp();

        $this->mockAPI();

        $application = new ConsoleApplication();

        $testedCommand = $this->app->make(FeedCommand::class);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('feed:run');

        $this->commandTester = new CommandTester($this->command);

        $this->scenario();
    }

    abstract protected function scenario();
}
