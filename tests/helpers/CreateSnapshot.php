<?php

use App\Snapshot;

trait CreateSnapshot
{
    private function createSnapshots($count, $overrides = [])
    {
        return factory(Snapshot::class, $count)->create($overrides);
    }

    private function createSnapshot($overrides = [])
    {
        return factory(Snapshot::class)->create($overrides);
    }

    private function makeSnapshot()
    {
        return factory(Snapshot::class)->make();
    }
}
