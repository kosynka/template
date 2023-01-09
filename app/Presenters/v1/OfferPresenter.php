<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class OfferPresenter extends BasePresenter
{
    public function forOrder()
    {
        return [
            'id' => $this->id,
            'executor' => $this->executor ? (new ExecutorPresenter($this->executor))->shortInfo() : null,
            'status' => $this->status,
            'comment' => $this->comment,
        ];
    }

    public function executorsId()
    {
        return [
            'id' => $this->executor->id,
        ];
    }

    public function forExecutor()
    {
        return [
            'id' => $this->id,
            'order' => (new OrderPresenter($this->order))->list(),
            'status' => $this->status,
            'comment' => $this->comment,
        ];
    }
}
