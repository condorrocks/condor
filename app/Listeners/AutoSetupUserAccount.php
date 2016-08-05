<?php

namespace App\Listeners;

use App\Events\NewUserWasRegistered;
use App\User;

class AutoSetupUserAccount
{
    /**
     * Handle the event.
     *
     * @param NewUserWasRegistered $event
     *
     * @return void
     */
    public function handle(NewUserWasRegistered $event)
    {
        logger()->info(__METHOD__);

        $this->setupAccount($event->user);
    }

    protected function setupAccount(User $user)
    {
        logger()->debug('Setting up account for UserId: '.$user->id);

        $account = $user->accounts()->firstOrNew(['name' => 'default']);

        if (!$account->exists) {
            $user->accounts()->save($account);
        }
    }
}
