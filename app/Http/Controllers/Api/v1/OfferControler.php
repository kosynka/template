<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Offer\CreateOfferRequest;
use App\Services\v1\OfferService;

class OfferControler extends ApiController
{
    private OfferService $offerService;
    
    public function __construct()
    {
        $this->offerService = new OfferService();
    }

    public function create(CreateOfferRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->offerService->create($data));
    }

    public function accept(int $id)
    {
        return $this->result($this->offerService->accept($id));
    }

    public function decline(int $id)
    {
        return $this->result($this->offerService->decline($id));
    }
}
