<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UpdateTokenRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\SendVerifyRequest;
use App\Http\Requests\User\VerifyRequest;
use Illuminate\Http\Request;
use App\Services\v1\UserService;

class UserController extends ApiController
{
    private UserService $service;

    public function __construct() {
        $this->service = new UserService;
    }

    public function info($id)
    {
        return $this->result($this->service->info($id));
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->service->update($data));
    }

    public function updateToken(UpdateTokenRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->service->updateToken($this->authUser(), $data['fb_token']));
    }

    public function sendTwoVerify(SendVerifyRequest $request)
    {
        $data = $request->validated();
        
        $email = $data['email'];
        $phone = $data['phone'];
        
        $response = $this->service->sendTwoVerify($email, $phone);

        return $response;
    }

    public function verifyTwo(VerifyRequest $request)
    {
        $data = $request->validated();

        $tokenEmail = $data['tokenEmail'];
        $tokenPhone = $data['tokenPhone'];

        $response = $this->service->verifyTwo($tokenEmail, $tokenPhone);

        return $response;

        return $response;
    }

    public function sendVerify(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);
        
        return $this->result($this->service->sendVerify($data['email']));
    }

    public function verifyEmail(VerifyRequest $request)
    {
        $data = $request->validated();

        return $this->result($this->service->verifyEmail($data['token']));
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate(['phone' => 'required']);

        return $this->result($this->service->sendOtp($data['phone']));
    }

    public function verifyOtp(VerifyRequest $request)
    {
        $data = $request->validated();

        return $this->result($this->service->verifyOtp($data['token']));
    }
}
