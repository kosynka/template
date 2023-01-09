<?php

namespace App\Repositories;

use App\Models\Offer;

class OfferRepository
{
    public function create(array $data) : void
    {
        Offer::create($data);
    }

    public function update(Offer $offer, array $data) : void
    {
        $offer->update($data);
    }

    public function info(int $id)
    {
        return Offer::find($id);
    }

    public function getCreated(int $orderId)
    {
        return Offer::where('order_id', $orderId)
            ->where('status', Offer::STATUS_CREATED)
            ->get();
    }

    public function declineCreated(int $orderId) : void
    {
        Offer::where('order_id', $orderId)
            ->where('status', Offer::STATUS_CREATED)
            ->update(['status' => Offer::STATUS_DECLINED]);
    }

    public function declineOthers(int $orderId, int $executor_id) : void
    {
        Offer::where('order_id', $orderId)
            ->whereNot('executor_id', $executor_id)
            ->update(['status' => Offer::STATUS_DECLINED]);
    }
}
