<?php

namespace App\Providers;

use App\Events\ExecutorRatedEvent;
use App\Events\OfferUpdatedEvent;
use App\Events\ExecutorOrderUpdatedEvent;
use App\Events\UserOrderUpdatedEvent;
use App\Listeners\ExecutorRatedListener;
use App\Listeners\OfferUpdatedListener;
use App\Listeners\ExecutorOrderUpdatedListener;
use App\Listeners\UserOrderUpdatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        ExecutorRatedEvent::class => [
            ExecutorRatedListener::class,
        ],

        OfferUpdatedEvent::class => [
            OfferUpdatedListener::class,
        ],

        ExecutorOrderUpdatedEvent::class => [
            ExecutorOrderUpdatedListener::class,
        ],

        UserOrderUpdatedEvent::class => [
            UserOrderUpdatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
