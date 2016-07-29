<?php

namespace App\Policies;

use App\Board;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
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
     * @param Board $board
     *
     * @return bool
     */
    public function manage(User $user, Board $board)
    {
        $intersect = $user->accounts->intersect($board->accounts);

        return $intersect->count() > 0;
    }
}
