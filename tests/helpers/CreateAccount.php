<?php

use App\Account;

trait CreateAccount
{
    private function createAccounts($count, $overrides = [])
    {
        return factory(Account::class, $count)->create($overrides);
    }

    private function createAccount($overrides = [])
    {
        return factory(Account::class)->create($overrides);
    }

    private function makeAccount()
    {
        return factory(Account::class)->make();
    }
}
