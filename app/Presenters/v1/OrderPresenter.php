<?php

namespace App\Presenters\v1;
use App\Models\Offer;

use App\Presenters\BasePresenter;
use App\Services\v1\OrderService;

class OrderPresenter extends BasePresenter
{

    public function list()
    {
        return [
            'id' => $this->id,
            'user' => (new UserPresenter($this->user))->shortInfo(),
            'executor' => $this->executor ? (new ExecutorPresenter($this->executor))->shortInfo() : null,
            'city' => $this->city ? (new CityPresenter($this->city))->list() : null,
            'address' => $this->address,
            'created_at' => date('j.m.Y', strtotime($this->created_at)),
            'comment' => $this->comment,
            'status' => $this->status,
            'urgency' => $this->urgency ? (new UrgencyPresenter($this->urgency))->list() : null,
            'works_date' => $this->works_date,
            'images' => $this->image_path ? $this->image_path : null,
            'executors_id' => $this->offers ? $this->presentCollections($this->offers, OfferPresenter::class, 'executorsId') : null,
            'approved_offer' => $this->offer ? (new OfferPresenter($this->offer))->forOrder() : null,
            'reports' => $this->reports ? $this->presentCollections($this->reports, ReportPresenter::class, 'list') : null,
            'files' => $this->files ? $this->presentCollections($this->files, FilePresenter::class, 'list') : null,
        ];
    }
}
