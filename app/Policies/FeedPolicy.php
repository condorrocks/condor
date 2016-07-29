<?php

namespace App\Policies;

use App\Board;
use App\Feed;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedPolicy
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
     * Determine if the given board can be updated by the user.
     *
     * @param User     $user
     * @param Feed $feed
     *
     * @return bool
     */
    public function manage(User $user, Feed $feed, Board $board)
    {
        $intersect = $user->accounts->intersect($board->accounts);

        return $intersect->count() > 0 && $board->feeds->contains($feed);
    }
}
