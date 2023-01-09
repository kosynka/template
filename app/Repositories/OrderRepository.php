<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function index(array $params= [])
    {
        return Order::when($params, function ($query, $params) {
                if (isset($params['city_id'])) {
                    $query->where('city_id', $params['city_id']);
                }
            })
            ->get();
    }

    public function executorOrders(array $params = [])
    {
        return Order::where('status', Order::STATUS_CREATED)->
            when($params, function ($query, $params) {
                if (isset($params['city_id'])) {
                    $query->where('city_id', $params['city_id']);
                }
        })
        ->get();
    }

    public function executorOrdersByUserId(array $params = [])
    {
        return Order::where('user_id', $params['user_id'])
            ->when($params, function ($query, $params) {
                if (isset($params['city_id'])) {
                    $query->where('city_id', $params['city_id']);
                }
            })
        ->get();
    }

    public function onlyUserOrders(int $userId, array $params = [])
    {
        return Order::where('user_id', $userId)
            ->get();
    }

    public function store(array $data)
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data)
    {
        return $order->update($data);
    }

    public function info($id)
    {
        return Order::find($id);
    }

    public function waitReport(Order $order, array $data)
    {
        return $order->update($data);
    }

    public function approve(Order $order, array $data)
    {
        return $order->update($data);
    }

    public function notApprove(Order $order, array $data)
    {
        return $order->update($data);
    }

    public function delete(Order $order) : void
    {
        $order->delete();
    }

    public function userOrders(int $userId, array $statuses)
    {
        return Order::where('user_id', $userId)
            ->whereIn('status', $statuses)
            ->get();
    }
}
