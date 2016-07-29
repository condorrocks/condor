<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class SnapshotTest extends TestCase
{
    use DatabaseTransactions;
    use CreateSnapshot;

    /** @test */
    public function it_refers_to_a_target()
    {
        $snapshot = $this->createSnapshot([
            'target'    => 'example-target-resource',
            ]);

        $this->seeInDatabase('snapshots', ['target' => $snapshot->target, 'id' => $snapshot->id]);
    }

    /** @test */
    public function it_stores_captured_data()
    {
        $snapshot = $this->createSnapshot([
            'data' => json_encode(['key' => 'value']), ]);

        $this->assertEquals(
            $snapshot->data,
            json_encode(['key' => 'value'])
        );
    }

    /** @test */
    public function it_belongs_to_a_board()
    {
        $snapshot = $this->createSnapshot();

        $boardRelationship = $snapshot->board();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class, $boardRelationship);
    }

    /** @test */
    public function it_belongs_to_an_aspect()
    {
        $snapshot = $this->createSnapshot();

        $aspectRelationship = $snapshot->aspect();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class, $aspectRelationship);
    }
}
