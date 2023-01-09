<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ExecutorOrderUpdatedEvent;
use App\Models\Order;

class ExecutorOrderUpdatedListener
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
    public function handle(ExecutorOrderUpdatedEvent $event)
    {
        switch ($event->offer->status) {
            case Order::STATUS_APPROVED:
                (new PushNotificationService)->sendNotification($event->executor->fb_token, 'Заказ №'. $event->order->id, 'Ваш отчет принят', ['orderId' => $event->order->id]);
                break;
            case Order::STATUS_NOT_APPROVED:
                (new PushNotificationService)->sendNotification($event->executor->fb_token, 'Заказ №'. $event->order->id, 'Ваш отчет отклонен', ['orderId' => $event->order->id]);
                break;
            default:
                // code...
                break;
        }
    }
}
