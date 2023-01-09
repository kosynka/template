<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class UserPresenter extends BasePresenter
{
    public function info()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $this->photo_path ? url($this->photo_path) : null,
            'city' => $this->city ? (new CityPresenter($this->city))->list() : null,
            'business_type' => $this->business_type ? (new BusinessTypePresenter($this->business_type))->list() : null,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }

    public function shortInfo()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $this->photo_path ? url($this->photo_path) : null,
            'business_type' => $this->business_type ? (new BusinessTypePresenter($this->business_type))->list() : null,
        ];
    }
}
