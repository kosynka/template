<?php

namespace App\Services\v1;

use App\Models\Order;
use App\Models\User;
use App\Presenters\v1\UserPresenter;
use App\Repositories\ExecutorRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use App\Mail\VerifyEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use \App\Services\v1\Sms\Smsckz;

class UserService extends BaseService
{
    private ExecutorRepository $executorRepository;

    private UserRepository $userRepository;

    private Smsckz $smsckz;

    public function __construct() {
        $this->executorRepository = new ExecutorRepository();
        $this->userRepository = new UserRepository();
        $this->smsckz = new Smsckz();
    }

    public function info(int $userId)
    {
        $user = User::find($userId);
        if (is_null($user)) {
            return $this->errNotFound('Пользователь не найден');
        }

        $authExecutor = auth('api-executor')->user();
        if (!is_null($authExecutor)) {
            $order = Order::where('user_id', $userId)
                ->where('executor_id', $authExecutor->id)
                ->first();
            if (!is_null($order)) {
                return $this->result(['user' => (new UserPresenter($user))->info()]);
            }
        }

        $authUser = auth('api-user')->user();
        if (!is_null($authUser) && $authUser->id == $userId) {
            return $this->result(['user' => (new UserPresenter($user))->info()]);
        }

        return $this->result(['user' => (new UserPresenter($user))->shortInfo()]);
    }

    public function update(array $data)
    {
        $user = auth('api-user')->user();
        if (!$user) {
            return $this->errFobidden('Пользователь не авторизирован');
        }

        if (array_key_exists('phone', $data)) {
            if ($this->userRepository->findByPhone($data['phone']) && $user->phone != $data['phone']) {
                return $this->errNotAcceptable('Данный номер телефона уже занят');
            }

            $executorByPhone = $this->executorRepository->findByPhone($data['phone']);
            if ($executorByPhone) {
                if ($executorByPhone->user_id != $user->id) {
                    return $this->errNotAcceptable('Данный номер телефона уже занят');
                }
            }
        }
        if (array_key_exists('email', $data)) {
            if ($this->userRepository->findByEmail($data['email']) && $user->email != $data['email']) {
                return $this->errNotAcceptable('Данный адресом эл. почты уже занят');
            }

            $executorByEmail = $this->executorRepository->findByEmail($data['email']);
            if ($executorByEmail) {
                if ($executorByEmail->user_id != $user->id) {
                    return $this->errNotAcceptable('Данный адресом эл. почты уже занят');
                }
            }
        }

        if (isset($data['photo'])) {
            $path = $data['photo']->store('public/user');
            $data['photo_path'] = Storage::url($path);
        }

        $this->userRepository->update($user, $data);
        return $this->result(['user' => (new UserPresenter($user))->info()]);
    }

    public function updateToken(User $user, $token)
    {
        $this->userRepository->updateToken($user, $token);
        return $this->ok();
    }

    public function sendTwoVerify(string $email, string $phone)
    {
        $response['phone'] = $this->sendOtp($phone);
        $response['email'] = $this->sendVerify($email);

        return $response;
    }

    public function verifyTwo($tokenEmail, $tokenPhone)
    {
        $response['phone'] = $this->verifyOtp($tokenPhone);
        $response['email'] = $this->verifyEmail($tokenEmail);

        return $response;
    }

    public function sendVerify(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->errNotFound('Пользователь не найден');
        }

        $token = rand(100000, 999999);
        DB::table('verify_email_token')->insert([
            'email' => $user->email,
            'token' => $token,
        ]);

        Mail::to($user->email)->send(new VerifyEmail($token));
        Log::info(__METHOD__ . '. Верификация почты id:' . $user->email);

        return $this->ok('На вашу почту было высланно письмо подтверждения');
    }

    public function verifyEmail($token)
    {
        $verifyToken = DB::table('verify_email_token')->where('token', $token)->first();

        if (is_null($verifyToken)) {
            return $this->errNotFound('Неверный код');
        }

        $user = User::where('email', $verifyToken->email)->first();

        if (is_null($user)) {
            return $this->errNotFound('Пользователь не найден');
        }

        if ($user->hasVerifiedEmail()) {
            return $this->ok('Почта уже верифицирована');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        DB::table('verify_email_token')->where('token', $token)->delete();

        return $this->ok('Почта верифицирована');
    }

    public function sendOtp(string $phone)
    {
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return $this->errNotFound('Пользователь не найден');
        }

        $token = rand(100000, 999999);
        DB::table('verify_phone_token')->insert([
            'phone' => $user->phone,
            'token' => $token,
        ]);

        $phone = '+7' . str_replace(' ', '', $user['phone']);
        $id = str_replace(' ', '', $user['phone']);

        $url = 'https://smsc.kz/sys/send.php';

        $data = array(
            'login' => 'toozummer',
            'psw' => '2DB-R2z-fNM-3LQ',
            'phones' => $phone,
            'mes' => 'Ваш код подтверждения: ' . $token,
            'id' => $id,
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        Log::info(__METHOD__ . '. Верификация смс id:' . $id . ' result:' . $result);

        // if ($result == FALSE) {
        //     return $this->errNotFound($result);
        // }

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

        return $this->ok('Телефон верифицирован');
    }
}
