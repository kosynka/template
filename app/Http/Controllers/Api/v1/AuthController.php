<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\v1\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->authService->login($data));
    }

    public function logout(Request $request)
    {
        return $this->result($this->authService->logout());
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->authService->register($data));
    }

    public function sendForgot(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);
        return $this->result($this->authService->sendForgot($data['email']));
    }

    public function reset(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->authService->reset($data['password'], $data['token']));
    }
}
