<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class BoardTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBoard;

    /** @test */
    public function it_has_a_name()
    {
        $board = $this->createBoard([
            'name'    => 'hosting/example-board',
            ]);

        $this->seeInDatabase('boards', ['name' => $board->name, 'id' => $board->id]);
    }

    /** @test */
    public function it_belongs_to_accounts()
    {
        $board = $this->createBoard();

        $accountsRelationship = $board->accounts();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $accountsRelationship);
    }

    /** @test */
    public function it_holds_feeds()
    {
        $board = $this->createBoard();

        $feedsRelationship = $board->feeds();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $feedsRelationship);
    }

    /** @test */
    public function it_has_snapshots()
    {
        $board = $this->createBoard();

        $snapshotsRelationship = $board->snapshots();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class, $snapshotsRelationship);
    }
}
