<?php

namespace App\Services\v1;

use App\Events\ExecutorRatedEvent;
use App\Models\Executor;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Repositories\ReviewRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class ReviewService extends BaseService
{
    private ReviewRepository $reviewRepository;

    public function __construct() {
        $this->reviewRepository = new ReviewRepository();
    }

    public function create(array $data)
    {
        $user = auth('api-user')->user();
        if (!$user) {
            return $this->errFobidden('Пользователь не авторизирован');
        }

        $order = Order::find($data['order_id']);
        if (!$order) {
            return $this->errNotFound('Заказ не найден');
        }
        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        $review = Review::where('order_id', $data['order_id'])->first();
        if ($review) {
            return $this->errNotAcceptable('Вы не можете повторно оставить отзыв');
        }

        $executor = $order->executor;
        if (is_null($executor)) {
            return $this->errNotAcceptable('К заказу не привязан исполнитель.');
        }
        $data['user_id'] = $user->id;
        $data['executor_id'] = $executor->id;
        $this->reviewRepository->create($data);

        event(new ExecutorRatedEvent($executor));

        return $this->ok('Отзыв добавлен');
    }
}
