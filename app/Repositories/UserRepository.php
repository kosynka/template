<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;

class UserRepository
{

    public function store(array $data) : void
    {
        User::create($data);
    }

    public function update(User $user, array $data) : void
    {
        $user->update($data);
    }

    public function findBeforeRegistrationByPhone(string $phone)
    {
        return User::whereNull('phone_verified_at')->where('phone', $phone)->first();
    }

    public function findByPhone(string $phone)
    {
        return User::whereNotNull('phone_verified_at')->where('phone', $phone)->first();
    }

    public function findByEmail(string $email)
    {
        return User::whereNotNull('email_verified_at')->where('email', $email)->first();
    }

    public function updateToken(User $user, $token)
    {
        $user->fb_token = $token;
        $user->save();
    }

    public function markPhoneAsVerified(User $user)
    {
        $user->phone_verified_at = Carbon::now();
        $user->save();
    }
}
