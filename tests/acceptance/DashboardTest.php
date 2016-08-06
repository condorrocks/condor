<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardTest extends TestCase
{
    /**
     * @test
     */
    public function it_shows_the_homepage()
    {
        $this->visit('/')
             ->see('Condor');
    }
}
