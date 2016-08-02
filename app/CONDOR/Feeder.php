<?php

namespace App\Condor;

abstract class Feeder
{
    abstract public function feed();

    abstract public function getSnapshot();

    public function run()
    {
        try {
            $this->feed();
        } catch (\Exception $e) {
            logger()->error('Exception during Feed: '.$e->getMessage());
        }

        return $this;
    }
}
