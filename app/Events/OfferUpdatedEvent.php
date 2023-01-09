<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $offer;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
        $this->executor = $offer->executor;
    }

}
