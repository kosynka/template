<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\CreateReviewRequest;
use App\Services\v1\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends ApiController
{
    private ReviewService $reviewService;

    public function __construct() {
        $this->reviewService = new ReviewService();
    }

    public function create(CreateReviewRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->reviewService->create($data));
    }
}
