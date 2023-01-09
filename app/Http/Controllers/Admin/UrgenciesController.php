<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRequest;
use App\Models\Urgency;
use App\Models\Order;

class UrgenciesController extends Controller
{
    public function index()
    {
        $urgencies = Urgency::all();
        return view('admin.urgency', compact('urgencies'));
    }

    public function add()
    {
        return view('admin.add', ['model' => 'urgency', 'type' => 'Вид срочности']);
    }

    public function create(UpdateRequest $request)
    {
        $data = $request->validated();
        Urgency::create($data);
        return redirect('/admin/urgency');
    }

    public function edit($id)
    {
        $item = Urgency::find($id);
        if (is_null($item)) {
            return redirect()->back()->with('error', 'Вид срочности не найден');
        }
        $type = 'Вид срочности';
        $model = 'urgencies';

        return view('admin.edit', compact('type', 'item', 'model'));
    }

    public function update($id, UpdateRequest $request)
    {
        $data = $request->validated();
        $urgency = Urgency::find($id);
        if (is_null($urgency)) {
            return redirect()->back()->with('error', 'Вид срочности не найден');
        }
        $urgency->update($data);
        return redirect('/admin/urgency');
    }

    public function delete($id)
    {
        $urgency_id = Urgency::find($id)->id;
        
        $orders = Order::all()->where('urgency_id', $urgency_id);

        $this->detachRow($orders, $urgency_id);

        Urgency::find($id)->delete();
        return redirect('/admin/urgency');
    }

    private static function detachRow($data, $row)
    {
        foreach ($data as $column) {
            $column->urgency()->dissociate($row)->save();
        }
    }
}
