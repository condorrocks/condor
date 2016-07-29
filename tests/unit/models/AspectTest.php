<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AspectTest extends TestCase
{
    use DatabaseTransactions;
    use CreateAspect;

    /** @test */
    public function an_aspect_has_a_name()
    {
        $aspect = $this->createAspect([
            'name'    => 'uptime',
            ]);

        $this->seeInDatabase('aspects', ['name' => $aspect->name, 'id' => $aspect->id]);
    }

    /** @test */
    public function an_aspect_refers_to_feeds()
    {
        $aspect = $this->createAspect();

        $feedsRelationship = $aspect->feeds();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class, $feedsRelationship);
    }

    /** @test */
    public function an_aspect_refers_to_snapshots()
    {
        $aspect = $this->createAspect();

        $snapshotsRelationship = $aspect->snapshots();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class, $snapshotsRelationship);
    }
}
