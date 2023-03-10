<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BusinessType;

class BusinessTypeSeeder extends Seeder
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
                'name' => 'Аноним'
            ],
            [
                'name' => 'Юр.лицо'
            ],
            [
                'name' => 'Физ.лицо'
            ],
        ];

        foreach ($data as $type) {
            BusinessType::create($type);
        }
    }
}
