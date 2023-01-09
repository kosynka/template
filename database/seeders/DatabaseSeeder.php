<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new CitySeeder())->run();
        (new UrgencySeeder())->run();
        (new BusinessTypeSeeder())->run();
        (new UserSeeder())->run();
        (new ExecutorSeeder())->run();
        (new OrderSeeder())->run();
        (new AdminSeeder())->run();
        (new OfferSeeder())->run();
        (new ReportSeeder())->run();
    }
}
