<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class ReviewPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'user' => $this->user ? (new UserPresenter($this->user))->shortInfo() : null,
            'text' => $this->text,
            'rate' => $this->rate,
        ];
    }
}
