<?php

namespace App\Mail;

use App\Snapshot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SnapshotStatusChangeAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Snapshot
     */
    public $snapshot;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Snapshot $snapshot)
    {
        $this->snapshot = $snapshot;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.alerts.status-changed');
    }
}
