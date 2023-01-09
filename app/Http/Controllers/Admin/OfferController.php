<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::with(['order', 'executor'])->paginate(50);
        return view('admin.offer', compact('offers'));
    }
}