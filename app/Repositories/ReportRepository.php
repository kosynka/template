<?php

namespace App\Repositories;

use App\Models\Report;

class ReportRepository
{
    
    public function store(array $data)
    {
        $data['image_path'] = json_encode($data['image_path']);
        return Report::create($data);
    }
    
    // public function index()
    // {
    //     return Report::all()->get();
    // }

    // public function update(Order $order, array $data)
    // {
    //     return $order->update($data);
    // }

    // public function info($id)
    // {
    //     return Order::->find($id);
    // }
}
