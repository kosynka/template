<?php

namespace App\Services\v1;

use App\Presenters\v1\CityPresenter;
use App\Repositories\CityRepository;
use App\Services\BaseService;

class CityService extends BaseService
{
    private CityRepository $cityRepository;

    public function __construct() {
        $this->cityRepository = new CityRepository();
    }

    public function index()
    {
        $cities = $this->cityRepository->all();
        return $this->resultCollections($cities, CityPresenter::class, 'list');
    }
}
