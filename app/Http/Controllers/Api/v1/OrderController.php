<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\OrderService;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\OrderHistoryRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    private OrderService $orderService;

    public function __construct() {
        $this->orderService = new OrderService();
    }

    public function index()
    {
        return $this->result($this->orderService->index());
    }

    public function info(int $id)
    {
        return $this->result($this->orderService->info($id));
    }

    public function ordersIndexByUserId(int $id)
    {
        return $this->result($this->orderService->ordersIndexByUserId($id));
    }

    public function create(CreateOrderRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $this->authUser()->id;
        return $this->result($this->orderService->create($data));
    }

    public function update(int $id, UpdateOrderRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->orderService->update($id, $data));
    }

    public function waitReport(int $id)
    {
        return $this->result($this->orderService->waitReport($id));
    }

    public function approve(int $id)
    {
        return $this->result($this->orderService->approve($id));
    }

    public function notApprove(int $id)
    {
        return $this->result($this->orderService->notApprove($id));
    }

    public function delete(int $id)
    {
        return $this->result($this->orderService->delete($id));
    }

    public function offers(int $id)
    {
        return $this->result($this->orderService->offers($id));
    }

    public function userOrders(OrderHistoryRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->orderService->userOrders($data['status']));
    }

    public function finish(int $id)
    {
        return $this->result($this->orderService->finish($id));
    }
}
