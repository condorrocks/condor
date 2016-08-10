<?php

namespace App\Listeners;

use App\Account;
use App\Aspect;
use App\Board;
use App\Events\NewUserWasRegistered;
use App\Jobs\RunFeed;
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

        $account = $this->createAccount($user);

        $board = $this->createBoard($account);

        $this->createWhoisFeed($board);

        $this->createSSLCertificateFeed($board);

        dispatch(new RunFeed('whois', $board));

        dispatch(new RunFeed('sslcertificate', $board));
    }

    protected function createAccount(User $user)
    {
        $account = $user->accounts()->firstOrNew(['name' => 'default']);

        if (!$account->exists) {
            $user->accounts()->save($account);
        }

        return $account;
    }

    protected function createBoard(Account $account)
    {
        $board = $account->boards()->firstOrNew(['name' => 'example']);

        if (!$board->exists) {
            $account->boards()->save($board);
        }

        return $board;
    }

    protected function createWhoisFeed(Board $board)
    {
        return $this->createFeed($board, [
            'aspect'    => 'whois',
            'name'      => 'condor.rocks Domain',
            'params'    => '{"domain":"condor.rocks"}',
            ]);
    }

    protected function createSSLCertificateFeed(Board $board)
    {
        return $this->createFeed($board, [
            'aspect'    => 'sslcertificate',
            'name'      => 'condor.rocks SSL Certificate',
            'params'    => '{"url":"https://condor.rocks"}',
            ]);
    }

    protected function createFeed(Board $board, array $attributes)
    {
        $feed = $board->feeds()->create([
            'aspect_id' => Aspect::whereName(array_get($attributes, 'aspect'))->first()->id,
            'name'      => array_get($attributes, 'name'),
            'params'    => array_get($attributes, 'params'),
            ]);

        return $feed;
    }
}
