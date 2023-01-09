<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRequest;
use App\Models\BusinessType;
use App\Models\User;

class BusinessTypesController extends Controller
{
    public function index()
    {
        $business_types = BusinessType::all();
        return view('admin.business_type', compact('business_types'));
    }

    public function add()
    {
        return view('admin.add', ['model' => 'business_type', 'type' => 'Тип бизнеса']);
    }

    public function create(UpdateRequest $request)
    {
        $data = $request->validated();
        BusinessType::create($data);
        return redirect('/admin/business_type');
    }

    public function edit($id)
    {
        $item = BusinessType::find($id);
        if (is_null($item)) {
            return redirect()->back()->with('error', 'Тип бизнеса не найден');
        }
        $type = 'Тип бизнеса';
        $model = 'business_types';

        return view('admin.edit', compact('type', 'item', 'model'));
    }

    public function update($id, UpdateRequest $request)
    {
        $data = $request->validated();
        $business_type = BusinessType::find($id);
        if (is_null($business_type)) {
            return redirect()->back()->with('error', 'Тип бизнеса не найден');
        }
        $business_type->update($data);
        return redirect('/admin/business_type');
    }

    public function delete($id)
    {
        $business_type_id = BusinessType::find($id)->id;
        
        $users = User::all()->where('business_type_id', $business_type_id);
        
        $this->detachRow($users, $business_type_id);
        
        BusinessType::find($id)->delete();
        return redirect('/admin/business_type');
    }

    private static function detachRow($data, $row)
    {
        foreach ($data as $column) {
            $column->business_type()->dissociate($row)->save();
        }
    }
}
