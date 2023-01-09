<?php

namespace App\Services\v1\Sms;

/*
|--------------------------------------------------------------------------
| class SMSC to send SMS on Mobile Numbers via smsc.kz site
|--------------------------------------------------------------------------
*/

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;

class Smsckz
{
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function sendOtp(User $user)
    {
        $token = rand(100000, 999999);
        DB::table('verify_phone_token')->insert([
            'phone' => $user->phone,
            'token' => $token,
        ]);

        $phone = '+7' . str_replace(' ', '', $user['phone']);
        $id = str_replace(' ', '', $user['phone']);

        $url = 'https://smsc.kz/sys/send.php';

        $data = array(
            'login' => env('SMSCKZ_LOGIN'),
            'psw' => env('SMSCKZ_SECRET'),
            'phones' => $phone,
            'mes' => 'Ваш код подтверждения: ' . $token,
            'id' => $id,
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        dd($options);

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result == FALSE) {
            return $result;
        }

        return $this->ok('На ваш телефон был выслан код подтверждения');
    }

    public function verifyOtp($token)
    {
        $verifyToken = DB::table('verify_phone_token')->where('token', $token)->first();

        if (is_null($verifyToken)) {
            return $this->errNotFound('Неверный код');
        }

        $user = User::where('phone', $verifyToken->phone)->first();

        if (is_null($user)) {
            return $this->errNotFound('Пользователь не найден');
        }

        if ($user->hasVerifiedPhone()) {
            return $this->ok('Телефон уже верифицирована');
        }

        $this->userRepository->markPhoneAsVerified($user);

        DB::table('verify_phone_token')->where('token', $token)->delete();

        return $this->ok('Почта верифицирована');
    }

    protected function ok($message = 'OK') : array
    {
        return $this->result(['message' => $message]);
    }

    protected function errNotFound($message) : array
    {
        return $this->error(404, $message);
    }

    protected function result(array $data): array
    {
        Log::info(__METHOD__ . ' ' . $this->getInfoContext($data));
        $rData = ['success' => true] + $data;
        return [
            'data' => $rData,
            'httpCode' => 200
        ];
    }

    protected function error(int $code, string $message): array
    {
        Log::info(__METHOD__ . ' ' . $message);
        return [
            'data' => [
                'message' => $message,
                'success' => false,
            ],
            'httpCode' => $code
        ];
    }
}