<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
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
                'executor_id' => 1,
                'order_id' => 1,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'Some text for order 1',
            ],
            [
                'executor_id' => 2,
                'order_id' => 1,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'Some longer text for order 2',
            ],
            [
                'executor_id' => 3,
                'order_id' => 1,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'Some comment for',
            ],
            [
                'executor_id' => 1,
                'order_id' => 2,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'aaa bbb ccc',
            ],
            [
                'executor_id' => 2,
                'order_id' => 2,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'Some hhhhh',
            ],
            [
                'executor_id' => 3,
                'order_id' => 2,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'Some very very long comment',
            ],
            [
                'executor_id' => 1,
                'order_id' => 3,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'Sjk jfjlnm bber 2 order 2',
            ],
            [
                'executor_id' => 2,
                'order_id' => 3,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'Hello world hello',
            ],
            [
                'executor_id' => 3,
                'order_id' => 3,
                'status' => Offer::STATUS_CREATED,
                'comment' => 'fd fd fd cg cg cgg gcvehk',
            ],
            [
                'executor_id' => 1,
                'order_id' => 4,
                'status' => Offer::STATUS_ACCEPTED,
                'comment' => 'accepted offer comm for order 4',
            ],
        ];

        foreach ($data as $offer) {
            Offer::create($offer);
        }
    }
}
