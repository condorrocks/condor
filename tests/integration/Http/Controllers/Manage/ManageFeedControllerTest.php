<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageFeedControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateAccount, CreateBoard, CreateFeed;

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
     * @var App\Feed
     */
    protected $feed;

    /** @test */
    public function it_creates_a_new_feed()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->dontSeeInDatabase('feeds', ['apikey' => 'example-api-key']);

        $this->visit(route('manage.feeds.create', $this->board));

        $this->seePageIs("/feeds/create/board/{$this->board->id}");

        $this->type('example-feed', 'name');
        $this->type('example-api-key', 'apikey');
        $this->type('{"url":"http://condor.rocks"}', 'params');
        $this->press('Create');

        $this->see('Your feed was created');
        $this->seeInDatabase('feeds', ['apikey' => 'example-api-key']);
    }

    /** @test */
    public function it_updates_a_feed()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $oldApiKey = $this->feed->apikey;

        $this->seeInDatabase('feeds', ['apikey' => $oldApiKey]);

        $this->visit(route('manage.feeds.edit', [$this->feed->id, $this->board->id]));

        $this->seePageIs("/feeds/{$this->feed->id}/edit/board/{$this->board->id}");

        $this->type('new-example-api-key', 'apikey');
        $this->press('Update');

        $this->see('Your feed was successfully updated');
        $this->seeInDatabase('feeds', ['apikey' => 'new-example-api-key']);
        $this->dontSeeInDatabase('feeds', ['apikey' => $oldApiKey]);
    }

    /** @test */
    public function it_deletes_a_feed()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $oldApiKey = $this->feed->apikey;

        $this->seeInDatabase('feeds', ['apikey' => $oldApiKey]);

        $this->visit(route('manage.feeds.edit', [$this->feed->id, $this->board->id]));

        $this->seePageIs("/feeds/{$this->feed->id}/edit/board/{$this->board->id}");

        $this->press('Remove');

        $this->see('Your feed was successfully deleted');
        $this->dontSeeInDatabase('feeds', ['apikey' => $oldApiKey]);
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

        $this->feed = $this->createFeed();

        $this->board->feeds()->save($this->feed);
    }
}
