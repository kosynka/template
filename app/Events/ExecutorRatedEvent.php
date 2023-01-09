<?php

namespace App\Events;

use App\Models\Executor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExecutorRatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Executor $executor;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Executor $executor)
    {
        $this->executor = $executor;
    }
}
