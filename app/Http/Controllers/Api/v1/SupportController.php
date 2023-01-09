<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SupportRequest;
use App\Services\v1\SupportService;

class SupportController extends ApiController
{
    public function send(SupportRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        $data['name'] = $user->name;
        $data['phone'] = $user->phone;
        $data['email'] = $user->email;

        return $this->result((new SupportService())->send($data));
    }
}