<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Report;
use Carbon\Carbon;

class ReportSeeder extends Seeder
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
                'order_id' => 4,
                'executor_id' => 1,
                'type' => 'report_before',
                'image_path' => '["/storage/report/1661789069019_WdnI.jpeg", "/storage/report/166178923408.jpg"]',
                'comment' => 'Какой то коммент для Отчета ДО',
            ],
            [
                'order_id' => 4,
                'executor_id' => 1,
                'type' => 'report_after',
                'image_path' => '["/storage/user/pbbY3uhEd4QTTrwSXvcCmwkzyks5xbBGFdjCK1DD.jpg"]',
                'comment' => 'Не знаю что написать. Но с Вас 50 000 тенге',
            ],
            
        ];

        foreach ($data as $report) {
            Report::create($report);
        }
    }
}
