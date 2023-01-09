<?php

namespace App\Presenters\v1;

use App\Models\Order;
use App\Presenters\BasePresenter;

class ExecutorPresenter extends BasePresenter
{
    public function info()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $this->photo_path ? url($this->photo_path) : null,
            'city' => $this->city ? (new CityPresenter($this->city))->list() : null,
            'phone' => $this->phone,
            'email' => $this->email,
            'rating' => $this->rating,
            'orders_count' => $this->orders()->where('status', Order::STATUS_APPROVED) ? $this->orders()->where('status', Order::STATUS_APPROVED)->count() : 0,
            'offers' => $this->offers ? $this->presentCollections($this->offers, OfferPresenter::class, 'forExecutor') : null,
            'reviews' => $this->reviews ? $this->presentCollections($this->reviews, ReviewPresenter::class, 'list') : null,
        ];
    }

    public function shortInfo()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'photo' => $this->photo_path ? url($this->photo_path) : null,
            'city' => $this->city ? (new CityPresenter($this->city))->list() : null,
            'rating' => $this->rating,
            'orders_count' => $this->orders()->where('status', Order::STATUS_APPROVED) ? $this->orders()->where('status', Order::STATUS_APPROVED)->count() : 0,
        ];
    }
}
