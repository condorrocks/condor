<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegisterTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /**
     * @test
     */
    public function it_provides_successful_registration()
    {
        $user = $this->makeUser();

        $this->visit('/register');

        $this->seeRegistrationFormFields();

        $this->type($user->name, 'name');
        $this->type($user->email, 'email');
        $this->type('password', 'password');
        $this->type('password', 'password_confirmation');

        $this->press('Register');

        $this->seePageIs('/');
        $this->see($user->name);
    }

    /**
     * @test
     */
    public function it_denies_no_password_registration()
    {
        $user = $this->makeUser();

        $this->visit('/register');

        $this->seeRegistrationFormFields();

        $this->type($user->name, 'name');
        $this->type($user->email, 'email');

        $this->press('Register');

        $this->see('The password field is required.');
    }

    /////////////
    // Helpers //
    /////////////

    protected function seeRegistrationFormFields()
    {
        $this->see('Name');
        $this->see('E-Mail Address');
        $this->see('Password');
        $this->see('Confirm Password');

        $this->see('Register');
    }
}
