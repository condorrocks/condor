<?php

namespace App\Condor\Panels;

use App\Condor\Panels\PanelBuilder;

class PanelsBuilder
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
            $panels[] = with(new PanelBuilder($board))->get();
        }

        return $panels;
    }
}
