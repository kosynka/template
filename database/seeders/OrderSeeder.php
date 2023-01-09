<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'city_id' => 1,
                'address' => 'улица Пушкина, дом 1',
                'comment' => '1st order from seeder',
                'status' => Order::STATUS_CREATED,
                'urgency_id' => 1,
                'works_date' => Carbon::now(),
                'image_path' => '',
            ],
            [
                'user_id' => 1,
                'city_id' => 1,
                'address' => 'улица Абая, дом 2',
                'comment' => '2nd order from seeder',
                'status' => Order::STATUS_CREATED,
                'urgency_id' => 2,
                'works_date' => Carbon::now(),
                'image_path' => '',
            ],
            [
                'user_id' => 2,
                'city_id' => 1,
                'address' => 'улица Джона, дом 3',
                'comment' => '3rd order from seeder',
                'status' => Order::STATUS_CREATED,
                'urgency_id' => 3,
                'works_date' => Carbon::now(),
                'image_path' => '',
            ],
            [
                'user_id' => 2,
                'executor_id' => 1,
                'city_id' => 1,
                'address' => 'улица Джона, дом 3',
                'comment' => '3rd order from seeder',
                'status' => Order::STATUS_REPORT_SENT,
                'urgency_id' => 3,
                'works_date' => Carbon::now(),
                'image_path' => '',
            ],
        ];

        foreach ($data as $order) {
            Order::create($order);
        }
    }
}
