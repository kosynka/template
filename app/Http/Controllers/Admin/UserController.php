<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(50);
        return view('admin.user', compact('users'));
    }

    public function details($id)
    {
        $user = User::with('orders', 'offers')->find($id);

        return view('admin.user_details', compact('user'));
    }

    public function delete($id)
    {
        $user_id = User::find($id)->id;
        
        $orders = Order::all()->where('user_id', $user_id);
        $reviews = Review::all()->where('user_id', $user_id);

        $this->detachRow($orders, $user_id);
        $this->detachRow($reviews, $user_id);
        
        User::find($id)->delete();
        return redirect('/admin/user');
    }

    private static function detachRow($data, $row)
    {
        foreach ($data as $column) {
            $column->user()->dissociate($row)->save();
        }
    }

    private function encodeJsonImages($images)
    {
        if (isset($images)) {
            return json_decode($images);
        } else {
            return null;
        }
    }
}