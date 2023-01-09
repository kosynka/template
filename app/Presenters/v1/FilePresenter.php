<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class FilePresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'file_path' => url($this->file_path),
        ];
    }
}
