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

        $this->see('Your account was successfully created');
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

        $this->see('Your account was successfully updated');
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

    /////////////////////////////
    // Allow User into Account //
    /////////////////////////////

    /** @test */
    public function it_allows_an_additional_user_into_the_account()
    {
        $this->scenario();

        $otherUser = $this->createUser();

        $this->actingAs($this->user);

        $account = $this->account;

        $this->visit(route('manage.accounts.edit', compact('account')));

        $this->assertResponseOk();

        $this->assertEquals($otherUser->accounts()->count(), 0);

        $this->type($otherUser->email, 'email');
        $this->press('Allow User');

        $this->assertEquals($otherUser->accounts()->count(), 1);
    }

    /** @test */
    public function it_forbids_allowing_an_unexisting_additional_user_into_the_account()
    {
        $this->scenario();

        $otherUser = $this->createUser();

        $this->actingAs($this->user);

        $account = $this->account;

        $this->visit(route('manage.accounts.edit', compact('account')));

        $this->assertResponseOk();

        $this->assertEquals($otherUser->accounts()->count(), 0);

        $this->type('unexistent@email.com', 'email');
        $this->press('Allow User');

        $this->assertEquals($otherUser->accounts()->count(), 0);
        $this->see('no valid user found to allow account access');
    }

    /** @test */
    public function it_forbids_allowing_an_invalid_email()
    {
        $this->scenario();

        $otherUser = $this->createUser();

        $this->actingAs($this->user);

        $account = $this->account;

        $this->visit(route('manage.accounts.edit', compact('account')));

        $this->assertResponseOk();

        $this->assertEquals($otherUser->accounts()->count(), 0);

        $this->type('invalid email', 'email');
        $this->press('Allow User');

        $this->assertEquals($otherUser->accounts()->count(), 0);
        $this->see('The email must be a valid email address');
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
