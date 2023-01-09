<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class ReportPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'executor' => $this->executor ? (new ExecutorPresenter($this->executor))->shortInfo() : null,
            'type' => $this->type,
            'images' => $this->image_path ? array_map(function($link) {return url($link); }, json_decode($this->image_path)) : null,
            'comment' => $this->comment,
        ];
    }
}
