<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Services\v1\DictionaryService;

class DictionaryController extends ApiController
{
    private DictionaryService $service;

    public function __construct() {
        $this->service = new DictionaryService();
    }

    public function urgency()
    {
        return $this->result($this->service->urgency());
    }

    public function businessTypes()
    {
        return $this->result($this->service->businessTypes());
    }
}