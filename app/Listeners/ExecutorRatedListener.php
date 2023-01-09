<?php

namespace App\Listeners;

use App\Events\ExecutorRatedEvent;
use App\Services\v1\ExecutorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExecutorRatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ExecutorRatedEvent  $event
     * @return void
     */
    public function handle(ExecutorRatedEvent $event)
    {
        (new ExecutorService())->updateRating($event->executor);
    }
}
