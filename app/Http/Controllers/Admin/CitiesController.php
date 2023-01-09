<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRequest;
use App\Models\City;
use App\Models\User;
use App\Models\Executor;
use App\Models\Order;
use App\Models\Offer;

class CitiesController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('admin.city', compact('cities'));
    }

    public function add()
    {
        return view('admin.add', ['model' => 'city', 'type' => 'Город']);
    }

    public function create(UpdateRequest $request)
    {
        $data = $request->validated();
        City::create($data);
        return redirect('/admin/city');
    }

    public function edit($id)
    {
        $item = City::find($id);
        if (is_null($item)) {
            return redirect()->back()->with('error', 'Город не найден');
        }
        $type = 'Город';
        $model = 'cities';

        return view('admin.edit', compact('type', 'item', 'model'));
    }

    public function update($id, UpdateRequest $request)
    {
        $data = $request->validated();
        $city = City::find($id);
        if (is_null($city)) {
            return redirect()->back()->with('error', 'Город не найден');
        }
        $city->update($data);
        return redirect('/admin/city');
    }

    public function delete($id)
    {
        $city_id = City::find($id)->id;
        
        $users = User::all()->where('city_id', $city_id);
        $executors = Executor::all()->where('city_id', $city_id);
        $orders = Order::all()->where('city_id', $city_id);
        $offers = Offer::all()->where('city_id', $city_id);

        $this->detachRow($users, $city_id);
        $this->detachRow($executors, $city_id);
        $this->detachRow($orders, $city_id);
        $this->detachRow($offers, $city_id);

        City::find($id)->delete();
        return redirect('/admin/city');
    }

    private static function detachRow($data, $row)
    {
        foreach ($data as $column) {
            $column->city()->dissociate($row)->save();
        }
    }
}
