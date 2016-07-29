<?php

use App\Jobs\ClearSnapshots;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClearSnapshotsTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBoard, CreateSnapshot;

    /** @test */
    public function it_purges_all_snapshots_from_a_board()
    {
        $board = $this->createBoard();

        $snapshot1 = $this->createSnapshot();
        $snapshot2 = $this->createSnapshot();

        $board->snapshots()->save($snapshot1);
        $board->snapshots()->save($snapshot2);

        $this->seeInDatabase('snapshots', ['target' => $snapshot1->target]);
        $this->seeInDatabase('snapshots', ['target' => $snapshot2->target]);

        dispatch(new ClearSnapshots($board));

        $this->dontSeeInDatabase('snapshots', ['target' => $snapshot1->target]);
        $this->dontSeeInDatabase('snapshots', ['target' => $snapshot2->target]);
    }
}
