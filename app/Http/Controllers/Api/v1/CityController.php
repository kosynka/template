<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Services\v1\CityService;

class CityController extends ApiController
{
    private CityService $cityService;

    public function __construct() {
        $this->cityService = new CityService();
    }

    public function index ()
    {
        return $this->result($this->cityService->index());
    }
}
