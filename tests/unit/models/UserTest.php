<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /** @test */
    public function a_user_has_email_and_password()
    {
        $user = $this->createUser([
            'email'    => 'guest@example.org',
            'password' => bcrypt('demoguest'),
            ]);

        $this->seeInDatabase('users', ['email' => $user->email, 'id' => $user->id]);
    }

    /** @test */
    public function a_user_owns_accounts()
    {
        $user = $this->createUser();

        $accountsRelationship = $user->accounts();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $accountsRelationship);
    }

    /** @test */
    public function a_user_owns_boards_through_accounts()
    {
        $user = $this->createUser();

        $boardsRelationship = $user->boards();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasManyThrough::class, $boardsRelationship);
    }
}
