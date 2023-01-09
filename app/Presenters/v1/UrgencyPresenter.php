<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class UrgencyPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
