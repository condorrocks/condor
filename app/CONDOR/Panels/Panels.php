<?php

namespace App\Condor\Panels;

class Panels
{
    private $boards;

    public function __construct($boards)
    {
        $this->boards = $boards;
    }

    public function get()
    {
        $panels = [];
        foreach ($this->boards as $board) {
            $panels[] = with(new Panel($board))->get();
        }

        return $panels;
    }
}
