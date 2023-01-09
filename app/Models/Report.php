<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'executor_id',
        'type',
        'image_path',
        'comment',
    ];

    public function executor()
    {
        return $this->belongsTo(Executor::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
