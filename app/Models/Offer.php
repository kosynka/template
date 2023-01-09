<?php

namespace App\Models;

use App\Events\OfferUpdatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    const STATUS_CREATED = 'CREATED';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_DECLINED = 'DECLINED';

    protected $fillable = [
        'executor_id',
        'order_id',
        'status',
        'comment',
    ];

    protected $dispatchesEvents = [
        'updated' => OfferUpdatedEvent::class,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function executor()
    {
        return $this->belongsTo(Executor::class);
    }

    public function getStatus() : string
    {
        switch ($this->status) {
            case self::STATUS_ACCEPTED:
                return 'Принят';
                break;
            case self::STATUS_CREATED:
                return 'Создан';
                break;
            case self::STATUS_DECLINED:
                return 'Отклонён';
                break;
            default:
                return '';
                break;
        }
    }
}
