<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_WAITING_FOR_REPORT = 'WAITING_FOR_REPORT';
    const STATUS_AT_WORK = 'AT_WORK';
    const STATUS_REPORT_SENT = 'REPORT_SENT';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_NOT_APPROVED = 'NOT_APPROVED';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'offer_id',
        'executor_id',
        'city_id',
        'address',
        'urgency_id',
        'status',
        'comment',
        'works_date',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function urgency()
    {
        return $this->belongsTo(Urgency::class);
    }

    public function getStatus() : string
    {
        switch ($this->status) {
            case self::STATUS_CREATED:
                return 'Новая заявка';
                break;
            case self::STATUS_WAITING_FOR_REPORT:
                return 'Ожидание отчёта(до)';
                break;
            case self::STATUS_AT_WORK:
                return 'На исполнение';
                break;
            case self::STATUS_REPORT_SENT:
                return 'Отправлен отчёт(после)';
                break;
            case self::STATUS_APPROVED:
                return 'Завершена';
                break;
            case self::STATUS_NOT_APPROVED:
                return 'Не Одобрена';
                break;
            default:
                return '';
                break;
        }
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'order_id', 'id');
    }

    public function reportsBefore()
    {
        return $this->reports()->where('type', 'report_before');
    }

    public function reportsAfter()
    {
        return $this->reports()->where('type', 'report_after');
    }

    public function executor()
    {
        return $this->belongsTo(Executor::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
