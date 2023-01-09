<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone',
        'name',
        'email',
        'password',
        'fb_token',
        'photo_path',
        'city_id',
        'business_type_id',
        'email_verified_at',
        'phone_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function business_type()
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function offers()
    {
        return $this->hasManyThrough(Offer::class, Order::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function routeNotificationForSmscru()
    {
        return $this->phone;
    }

    public function hasVerifiedPhone()
    {
        return $this->phone_verified_at ? True : False;
    }
}
