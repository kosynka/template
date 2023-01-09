<?php

namespace App\Services\v1;

use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OfferRepository;
use App\Repositories\ReportRepository;
use App\Repositories\OrderRepository;
use App\Services\BaseService;

class OfferService extends BaseService
{
    private OfferRepository $offerRepository;
    private OrderRepository $orderRepository;

    public function __construct()
    {
        $this->offerRepository = new OfferRepository();
        $this->orderRepository = new OrderRepository();
    }

    public function create(array $data)
    {
        $executor = auth('api-executor')->user();
        $order = Order::find($data['order_id']);

        if (!$executor) {
            return $this->errNotFound('Исполнитель не найден');
        }
        if (!$executor->offers()->where('order_id', $data['order_id'])->get()->isEmpty()) {
            return $this->errNotAcceptable('Повторно оставить предложение нельзя');
        }

//        if ($order->status == Order::STATUS_CREATED) {
//            $this->orderRepository->acceptOffers($order, ['status' => Order::STATUS_ACCEPTS_OFFERS]);
//        }
//        elseif ($order->status == Order::STATUS_ACCEPTS_OFFERS) {
//            // pass by and keep the status
//        }
//        else {
//            return $this->errNotFound('Заявка не может перейти на этот статус');
//        }

        $data['executor_id'] = $executor->id;
        $data['status'] = Offer::STATUS_CREATED;
        $this->offerRepository->create($data);

        $user = User::find($order->user_id);
        (new PushNotificationService())->sendNotification($user->fb_token, 'Новое предложение', 'На ваш заказ №'.$order->id. ' поступило новое предложение', ['orderId' => $data['order_id']]);

        return $this->ok('Предложение создано');
    }

    public function accept(int $id)
    {
        $offer = $this->offerRepository->info($id);
        if (!$offer) {
            return $this->errNotFound('Предложение не найдено');
        }

        $user = auth('api-user')->user();
        if (!$user) {
            return $this->errFobidden('Требуется авторизация');
        }
        if (!($user->offers()->find($offer->id))) {
            return $this->errNotAcceptable('Вы не имеете доступа к данной заявке');
        }

        $this->offerRepository->update($offer, ['status' => Offer::STATUS_ACCEPTED]); // TODO Timer for OFFER_ACCEPTED

        $offers = Offer::all()->where('order_id', $offer->order->id)->where('status', Offer::STATUS_CREATED)->where('executor_id', '!=', $offer->executor->id);
        foreach ($offers as $offer) {
            (new PushNotificationService)->sendNotification($offer->executor->fb_token, 'Заказ №'. $offer->order->id, 'Ваше предложение отклонено', ['orderId' => $offer->order->id]);
        }

        $data = [
            'offer_id' => $offer->id,
            'executor_id' => $offer->executor_id,
            'status' => Order::STATUS_WAITING_FOR_REPORT,
        ];

        (new OrderService())->update($offer->order_id, $data);

        $this->offerRepository->declineCreated($offer->order_id);

        return $this->ok('Предложение одобрено');
    }

    public function decline(int $id)
    {
        $offer = $this->offerRepository->info($id);
        if (!$offer) {
            return $this->errNotFound('Предложение не найдено');
        }

        $user = auth('api-user')->user();

        if (!$user) {
            return $this->errFobidden('Требуется авторизация');
        }

        if (!($user->offers()->find($offer->id))) {
            return $this->errNotAcceptable('Вы не имеете доступа к данной заявке');
        }

        $this->offerRepository->update($offer, ['status' => Offer::STATUS_DECLINED]);

        return $this->ok('Предложение отклонено');
    }
}
