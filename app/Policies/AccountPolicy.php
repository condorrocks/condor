<?php

namespace App\Policies;

use App\Account;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given account can be managed by the user.
     *
     * @param User     $user
     * @param Account $account
     *
     * @return bool
     */
    public function manage(User $user, Account $account)
    {
        return $user->accounts->contains($account);
    }
}
