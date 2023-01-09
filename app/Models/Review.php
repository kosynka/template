<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'executor_id',
        'user_id',
        'rate',
        'text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function executor()
    {
        return $this->belongsTo(Executor::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
