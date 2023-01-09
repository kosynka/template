<?php

namespace App\Repositories;

use App\Models\Executor;
use App\Models\Offer;
use App\Models\Order;

class ExecutorRepository
{
    public function store(array $data) : void
    {
        Executor::create($data);
    }

    public function update(Executor $executor, array $data) : void
    {
        $executor->update($data);
    }

    public function info(int $id)
    {
        return Executor::with('offers', 'city')
            ->find($id);
    }

    public function getByExecutorId(int $user_id)
    {
        return Executor::where('user_id', $user_id)
            ->first();
    }

    public function isExist(int $user_id) : bool
    {
        $executor = Executor::where('user_id', $user_id)->first();
        return !is_null($executor);
    }

    public function findByPhone(string $phone)
    {
        return Executor::where('phone', $phone)->first();
    }

    public function findByEmail(string $email)
    {
        return Executor::where('email', $email)->first();
    }

    public function getOffers(int $executor_id)
    {
        return Offer::where('executor_id', $executor_id)
            ->whereNot('status', Offer::STATUS_DECLINED)
            ->get();
    }

    public function getAllExecutorRelatedOrders(int $executor_id)
    {
        return Order::whereIn('id', function($query) use ($executor_id){
                $query->select('offers.order_id')
                    ->from(with(new Offer)->getTable())
                        ->where('executor_id', $executor_id)
                        ->whereNot('status', Offer::STATUS_DECLINED);
            })->orWhere('executor_id', $executor_id)
            ->get();
    }

    public function updateToken(Executor $user, $token)
    {
        $user->fb_token = $token;
        $user->save();
    }
}
