<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserLoginTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /**
     * @test
     */
    public function it_provides_successful_login()
    {
        $user = $this->createUser(['email' => 'test@example.org', 'password' => bcrypt('password')]);

        $user = $this->performLogin($user);
        
        $this->see($user->name);
    }

    /**
     * @test
     */
    public function it_logs_audit_fields_upon_successful_login()
    {    
        $user = $this->createUser(['email' => 'test@example.org', 'password' => bcrypt('password')]);

        $user = $this->performLogin($user);

        $this->assertNotNull($user->fresh()->last_ip);

        $firstLoginAt = $user->fresh()->last_login_at;

        $this->assertInstanceOf(Carbon\Carbon::class, $firstLoginAt);

        sleep(1);

        $user = $this->performLogin($user);

        $secondLoginAt = $user->fresh()->last_login_at;

        $this->assertInstanceOf(Carbon\Carbon::class, $secondLoginAt);
        $this->assertNotEquals($firstLoginAt, $secondLoginAt);
    }

    protected function performLogin($user)
    {
        $this->visit('logout');
        $this->visit('login');

        $this->see('Login');
        $this->see('Password');
        $this->see('Remember me');

        $this->type($user->email, 'email');
        $this->type('password', 'password');

        $this->press('Login');

        return $user->fresh();
    }

    /**
     * @test
     */
    public function it_provides_logout()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit('logout');

        $this->seePageIs('/');

        $this->see('Login');
    }

    /**
     * @test
     */
    public function it_denies_bad_login()
    {
        $user = $this->createUser(['email' => 'test@example.org', 'password' => bcrypt('password')]);

        $this->visit('login');

        $this->see('Login');
        $this->see('Password');
        $this->see('Remember me');

        $this->type($user->email, 'email');
        $this->type('BAD PASSWORD!', 'password');

        $this->press('Login');

        $this->see('These credentials do not match our records');
    }

    /**
     * @test
     */
    public function it_requests_login_when_attempting_to_access_a_protected_page()
    {
        $this->visit(route('dashboard'));

        $this->seePageIs('login');

        $this->see('Login');
        $this->see('Password');
        $this->see('Remember me');
    }
}
