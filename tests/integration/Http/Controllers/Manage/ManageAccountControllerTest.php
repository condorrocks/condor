<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageAccountControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateUser, CreateAccount;

    protected $account;

    protected $user;

    /**
     * @test
     */
    public function it_lists_user_accounts()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->visit(route('manage.accounts.index'));

        $this->seePageIs('/accounts');
        $this->see($this->account->name);
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
