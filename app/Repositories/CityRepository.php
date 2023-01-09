<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{
    public function all()
    {
        return City::all();
    }
}
