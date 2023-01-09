<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository
{
    public function create(array $data)
    {
        Review::create($data);
    }
}
