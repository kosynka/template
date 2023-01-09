<?php

namespace App\Services\v1;

use App\Models\Executor;
use App\Presenters\v1\ExecutorPresenter;
use App\Presenters\v1\OfferPresenter;
use App\Presenters\v1\OrderPresenter;
use App\Repositories\ExecutorRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ExecutorService extends BaseService
{
    private ExecutorRepository $executorRepository;
    private UserRepository $userRepository;

    public function __construct() {
        $this->executorRepository = new ExecutorRepository();
        $this->userRepository = new UserRepository();
    }

    public function create(array $data)
    {
        if ($this->userRepository->findByPhone($data['phone']) || $this->executorRepository->findByPhone($data['phone'])) {
            return $this->errNotAcceptable('Данный номер телефона уже занят');
        }
        if ($this->userRepository->findByEmail($data['email']) || $this->executorRepository->findByEmail($data['email'])) {
            return $this->errNotAcceptable('Данный адрес эл. почты уже занят');
        }

        $data['password'] = Hash::make($data['password']);
        if(isset($data['photo_path'])) {
            $path = $data['photo_path']->store('public/executor');
            $data['photo_path'] = Storage::url($path);
        }

        $this->executorRepository->store($data);
        $executor = $this->executorRepository->findByPhone($data['phone']);
        $data['fb_token'] = $executor->createToken($executor->email, ['executor'])->plainTextToken;
        $executor->update($data);

        return $this->result([
            'token' => $executor->fb_token,
            'executor' => (new ExecutorPresenter($executor))->info(),
        ]);
    }

    public function update(array $data)
    {
        $executor = auth('api-executor')->user();
        if (!$executor) {
            return $this->errNotFound('Исполнитель не найден');
        }

        if (array_key_exists('phone', $data)) {
            if ($this->executorRepository->findByPhone($data['phone']) && $executor->phone != $data['phone']) {
                return $this->errNotAcceptable('Данный номер телефона уже занят');
            }

            $userByPhone = $this->userRepository->findByPhone($data['phone']);
            if ($userByPhone) {
                if ($userByPhone->id != $executor->id) {
                    return $this->errNotAcceptable('Данный номер телефона уже занят');
                }
            }
        }
        if (array_key_exists('email', $data)) {
            if ($this->executorRepository->findByEmail($data['email']) && $executor->email != $data['email']) {
                return $this->errNotAcceptable('Данный адрес эл. почты уже занят');
            }

            $userByEmail = $this->userRepository->findByEmail($data['email']);
            if ($userByEmail) {
                if ($userByEmail->id != $executor->user_id) {
                    return $this->errNotAcceptable('Данный адрес эл. почты уже занят');
                }
            }
        }

        if (isset($data['photo'])) {
            $path = $data['photo']->store('public/executor');
            $data['photo_path'] = Storage::url($path);
        }
        $this->executorRepository->update($executor, $data);

        return $this->result(['executor' => (new ExecutorPresenter($executor))->info()]);
    }

    public function info(int $id)
    {
        $executor = $this->executorRepository->info($id);

        if (!$executor) {
            return $this->errNotFound('Исполнитель не найден');
        }

        return $this->result(['executor' => (new ExecutorPresenter($executor))->info()]);
    }

    public function updateRating(Executor $executor) : void
    {
        $reviews = $executor->reviews()->limit(40)->orderBy('id', 'DESC')->get();

        $sum = 0;
        foreach ($reviews as $review) {
            $sum += $review->rate;
        }

        $avrRating = round($sum / $reviews->count(), 1);

        $this->executorRepository->update($executor, ['rating' => $avrRating]);
    }

    public function offers()
    {
        $executor = auth('api-executor')->user();

        if (!$executor) {
            return $this->errNotFound('Исполнитель не найден');
        }

        $offers = $this->executorRepository->getOffers($executor->id);
        $offers = $this->resultCollections($offers, OfferPresenter::class, 'forExecutor');

        $orders = $this->executorRepository->getAllExecutorRelatedOrders($executor->id);
        $orders = $this->resultCollections($orders, OrderPresenter::class, 'list')['data']['list'];

        $offers['data']['orders_list'] = $orders;

        return $offers;
    }

    public function updateToken(Executor $user, $token)
    {
        $this->executorRepository->updateToken($user, $token);
        return $this->ok();
    }
}
