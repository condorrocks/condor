<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageBoardControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateUser, CreateAccount, CreateBoard;

    /**
     * @var App\User
     */
    protected $user;

    /**
     * @var App\Account
     */
    protected $account;

    /** @test */
    public function it_lists_all_boards()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->visit(route('manage.boards.index'));

        $this->assertResponseOk();
        $this->seePageIs('/boards');
    }

    /** @test */
    public function it_adds_a_new_board()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->visit(route('manage.boards.create'));

        $this->assertResponseOk();

        $this->dontSeeInDatabase('boards', ['name' => 'testboard']);

        $this->type('testboard', 'name');
        $this->press('Create');

        $this->seeInDatabase('boards', ['name' => 'testboard']);
    }

    /** @test */
    public function it_edits_a_board()
    {
        $this->scenario();

        $board = $this->createBoard();

        $this->account->boards()->save($board);

        $this->actingAs($this->user);

        $this->visit(route('manage.boards.edit', compact('board')));

        $this->assertResponseOk();

        $this->seeInDatabase('boards', ['name' => $board->name]);

        $editedName = 'edited-board-name';

        $this->type($editedName, 'name');
        $this->press('Update');

        $this->seeInDatabase('boards', ['name' => $editedName]);
    }

    /** @test */
    public function it_removes_a_board()
    {
        $this->scenario();

        $board = $this->createBoard();

        $this->account->boards()->save($board);

        $this->actingAs($this->user);

        $this->seeInDatabase('boards', ['name' => $board->name]);

        $this->visit(route('manage.boards.edit', compact('board')));

        $this->assertResponseOk();

        $this->press('Remove');

        $this->dontSeeInDatabase('boards', ['name' => $board->name]);
    }

    /** @test */
    public function it_shows_board_details()
    {
        $this->scenario();

        $board = $this->createBoard();

        $this->account->boards()->save($board);

        $this->actingAs($this->user);

        $this->seeInDatabase('boards', ['name' => $board->name]);

        $this->visit(route('manage.boards.show', compact('board')));

        $this->assertResponseOk();
        $this->see($board->name);
    }

    //////////////////////
    // Scenario Helpers //
    //////////////////////

    protected function scenario()
    {
        $this->user = $this->createUser();

        $this->account = $this->createAccount();

        $this->user->accounts()->save($this->account);
    }
}
