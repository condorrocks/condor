<?php

namespace App\Condor;

interface Feeder
{
    public function run();

    public function getSnapshot();
}
