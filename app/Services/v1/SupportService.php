<?php

namespace App\Services\v1;

use App\Mail\SupportMessage;
use App\Services\BaseService;
use Illuminate\Support\Facades\Mail;

class SupportService extends BaseService
{
    public function send(array $data)
    {
        Mail::to('m.plast.taraz@mail.ru')->send(new SupportMessage($data));
        return $this->ok('Сообщение отправленно');
    }
}