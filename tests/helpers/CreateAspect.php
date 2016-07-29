<?php

use App\Aspect;

trait CreateAspect
{
    private function createAspects($count, $overrides = [])
    {
        return factory(Aspect::class, $count)->create($overrides);
    }

    private function createAspect($overrides = [])
    {
        return factory(Aspect::class)->create($overrides);
    }

    private function makeAspect()
    {
        return factory(Aspect::class)->make();
    }
}
