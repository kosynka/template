<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Urgency;

class UrgencySeeder extends Seeder
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
                'name' => 'Срочный'
            ],
            [
                'name' => 'Средне срочный'
            ],
            [
                'name' => 'Не срочный'
            ],
        ];

        foreach ($data as $urgency) {
            Urgency::create($urgency);
        }
    }
}
