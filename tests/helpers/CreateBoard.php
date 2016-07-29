<?php

use App\Board;

trait CreateBoard
{
    private function createBoards($count, $overrides = [])
    {
        return factory(Board::class, $count)->create($overrides);
    }

    private function createBoard($overrides = [])
    {
        return factory(Board::class)->create($overrides);
    }

    private function makeBoard()
    {
        return factory(Board::class)->make();
    }
}
