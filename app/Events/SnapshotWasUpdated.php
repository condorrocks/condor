<?php

namespace App\Events;

use App\Snapshot;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class SnapshotWasUpdated
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Snapshot
     */
    public $snapshot;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Snapshot $snapshot)
    {
        $this->snapshot = $snapshot;
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
