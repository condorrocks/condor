<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeedTest extends TestCase
{
    use DatabaseTransactions;
    use CreateFeed;

    /** @test */
    public function it_has_a_name_and_parameters()
    {
        $feed = $this->createFeed([
            'name'    => 'hosting/example-target',
            'apikey'  => 'EXAMPLE-API-KEY-928375386598347983562',
            'params'  => json_encode(['param1' => 'value1']),
            ]);

        $this->seeInDatabase('feeds', ['name' => $feed->name, 'id' => $feed->id]);
    }

    /** @test */
    public function it_belongs_to_boards()
    {
        $feed = $this->createFeed();

        $boardsRelationship = $feed->boards();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $boardsRelationship);
    }

    /** @test */
    public function it_belongs_to_one_aspect()
    {
        $feed = $this->createFeed();

        $aspectRelationship = $feed->aspect();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class, $aspectRelationship);
    }

    /** @test */
    public function it_scopes_for_aspect()
    {
        $feed = $this->createFeed();

        $scope = $feed->forAspect('aspect');

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Builder::class, $scope);
    }
}
