<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Sanctum\HasApiTokens;

class Executor extends Model
{
    use HasFactory, HasApiTokens, Notifiable, Authorizable;

    protected $fillable = [
        'city_id',
        'email',
        'phone',
        'name',
        'photo_path',
        'balance',
        'password',
        'rating',
        'fb_token'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function reportsBefore()
    {
        return $this->reports()->where('type', 'report_before');
    }

    public function reportsAfter()
    {
        return $this->reports()->where('type', 'report_after');
    }
}
