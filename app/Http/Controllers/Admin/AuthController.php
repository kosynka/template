<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/admin/login');
    }

    public function signin(LoginRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::where('username', $data['username'])->first();
        if (is_null($admin)) {
            return redirect()->back()->with('error', 'Неверные имя пользователя или пароль');
        }

        if (!Hash::check($data['password'], $admin->password)) {
            return redirect()->back()->with('error', 'Неверные имя пользователя или пароль');
        }

        $remember = false;
        if (isset($data['remember'])) {
            $remember = true;
        }

        Auth::guard('web')->login($admin, $remember);

        return redirect('/admin');
    }

    public function edit()
    {
        $admin = Auth::user();

        return view('admin.admin', compact('admin'));
    }

    public function update(UpdateAdminRequest $request)
    {
        $admin = Auth::user();

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        
        $admin->update($data);

        return redirect()->back()->with('message', 'Данные успешно изменены');
    }

    public function store(UpdateAdminRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        Admin::create($data);

        return redirect()->back()->with('message', 'Данные успешно изменены');
    }
}