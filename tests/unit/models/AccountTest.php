<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{
    use DatabaseTransactions;
    use CreateAccount;

    /** @test */
    public function an_account_has_a_name()
    {
        $account = $this->createAccount([
            'name'    => 'My Free Account',
            ]);

        $this->seeInDatabase('accounts', ['name' => $account->name, 'id' => $account->id]);
    }

    /** @test */
    public function an_account_holds_boards()
    {
        $account = $this->createAccount();

        $boardsRelationship = $account->boards();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $boardsRelationship);
    }

    /** @test */
    public function an_account_holds_snapshots_through_boards()
    {
        $account = $this->createAccount();

        $snapshotsRelationship = $account->snapshots();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasManyThrough::class, $snapshotsRelationship);
    }
}
