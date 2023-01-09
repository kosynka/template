<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'phone' => '747 940 0950',
                'email' => 'snaiperov60@gmail.com',
                'password' => Hash::make('123'),
                'city_id' => 1,
                'business_type_id' => 2,
                'name' => 'Sniperov User',
            ],
            [
                'phone' => '747 940 0951',
                'email' => 'coolzombo@gmail.com',
                'password' => Hash::make('123'),
                'city_id' => 1,
                'business_type_id' => 2,
                'name' => 'Insane User',
            ]
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}
