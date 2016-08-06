<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageAccountControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateAccount;

    /**
     * @var App\User
     */
    protected $user;

    /**
     * @var App\Account
     */
    protected $account;

    /** @test */
    public function it_lists_user_accounts()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->visit(route('manage.accounts.index'));

        $this->seePageIs('/accounts');
        $this->see($this->account->name);
    }

    /** @test */
    public function it_adds_a_new_account()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $this->visit(route('manage.accounts.create'));

        $this->assertResponseOk();

        $name = 'testaccount';

        $this->dontSeeInDatabase('accounts', compact('name'));

        $this->type($name, 'name');
        $this->press('Create');

        $this->seeInDatabase('accounts', compact('name'));
    }

    /** @test */
    public function it_edits_an_account()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $account = $this->account;

        $this->visit(route('manage.accounts.edit', compact('account')));

        $this->assertResponseOk();

        $this->seeInDatabase('accounts', ['name' => $account->name]);

        $editedName = 'edited-account-name';

        $this->type($editedName, 'name');
        $this->press('Update');

        $this->seeInDatabase('accounts', ['name' => $editedName]);
    }

    /** @test */
    public function it_removes_an_account()
    {
        $this->scenario();

        $this->actingAs($this->user);

        $account = $this->account;

        $name = $account->name;

        $this->seeInDatabase('accounts', compact('name'));

        $this->visit(route('manage.accounts.edit', compact('account')));

        $this->assertResponseOk();

        $this->press('Remove');

        $this->dontSeeInDatabase('accounts', compact('name'));
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
