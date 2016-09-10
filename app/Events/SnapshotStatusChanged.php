<?php

namespace App\Events;

use App\Snapshot;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SnapshotStatusChanged
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Snapshot
     */
    public $snapshot;

    /**
     * @var int
     */
    public $newStatus;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $issues;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Snapshot $snapshot, $newStatus, Collection $issues)
    {
        $this->snapshot = $snapshot;

        $this->newStatus = $newStatus;

        $this->issues = $issues;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('snapshots');
    }
}
