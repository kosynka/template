<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRequest;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.home', compact('colors'));
    }

    public function add()
    {
        return view('admin.add', ['model' => 'color', 'type' => 'Цвет']);
    }

    public function create(UpdateRequest $request)
    {
        $data = $request->validated();
        Color::create($data);
        return redirect('/admin/color');
    }

    public function edit($id)
    {
        $item = Color::find($id);
        if (is_null($item)) {
            return redirect()->back()->with('error', 'Цвет не найден');
        }
        $type = 'Цвет';
        $model = 'color';

        return view('admin.edit', compact('type', 'item', 'model'));
    }

    public function update($id, UpdateRequest $request)
    {
        $data = $request->validated();
        $color = Color::find($id);
        if (is_null($color)) {
            return redirect()->back()->with('error', 'Цвет не найден');
        }
        $color->update($data);
        return redirect('/admin/color');
    }

    public function delete($id)
    {
        Color::find($id)->delete();
        return redirect('/admin/color');
    }
}