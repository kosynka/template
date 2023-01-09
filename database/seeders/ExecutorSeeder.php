<?php

namespace Database\Seeders;

use App\Models\Executor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExecutorSeeder extends Seeder
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
                'name' => 'Sniperov exec',
                'phone' => '700 700 7070',
                'email' => 'executor1@gmail.com',
                'password' => Hash::make('123'),
                'city_id' => 1,
            ],
            [
                'name' => 'Sayat exec',
                'phone' => '707 865 0366',
                'email' => 'executor2@gmail.com',
                'password' => Hash::make('123'),
                'city_id' => 1,
            ],
            [
                'name' => 'John',
                'phone' => '707 666 8888',
                'email' => 'executor3@gmail.com',
                'password' => Hash::make('123'),
                'city_id' => 1,
            ],
        ];

        foreach ($data as $executor) {
            Executor::create($executor);
        }
    }
}
