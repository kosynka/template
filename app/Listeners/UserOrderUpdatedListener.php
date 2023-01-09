<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserOrderUpdatedEvent;
use App\Models\Order;

class UserOrderUpdatedListener
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
    public function handle(UserOrderUpdatedEvent $event)
    {
        switch ($event->offer->status) {
            case Order::STATUS_AT_WORK:
                (new PushNotificationService)->sendNotification($event->user->fb_token, 'Заказ №'. $event->order->id, 'Исполнитель приступил к работе', ['orderId' => $event->order->id]);
                break;
            case Order::STATUS_REPORT_SENT:
                (new PushNotificationService)->sendNotification($event->user->fb_token, 'Заказ №'. $event->order->id, 'Исполнитель отправил отчет выполненной работы', ['orderId' => $event->order->id]);
                break;
            default:
                // code...
                break;
        }
    }
}
