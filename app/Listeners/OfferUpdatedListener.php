<?php

namespace App\Listeners;

use App\Events\OfferUpdatedEvent;
use App\Models\Offer;
use App\Services\v1\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OfferUpdatedListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(OfferUpdatedEvent $event)
    {
        switch ($event->offer->status) {
            case Offer::STATUS_ACCEPTED:
                (new PushNotificationService)->sendNotification($event->executor->fb_token, 'Заказ №'. $event->offer->order->id, 'Ваше предложение принято', ['orderId' => $event->offer->order->id]);
                break;
            case Offer::STATUS_DECLINED:
                (new PushNotificationService)->sendNotification($event->executor->fb_token, 'Заказ №'. $event->offer->order->id, 'Ваше предложение отклонено', ['orderId' => $event->offer->order->id]);
                break;
            default:
                // code...
                break;
        }
    }
}
