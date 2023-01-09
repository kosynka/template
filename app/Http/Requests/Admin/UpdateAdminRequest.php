<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'string', 'required_with:password', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Поле "Имя" обязательно для заполнения',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.min' => 'Пароль должен быть длиннее 6 символов',
            'password_confirmation.required' => 'Поле "Повторите пароль" обязательно для заполнения',
            'password_confirmation.same' => 'Пароли не совпадают',
        ];
    }
}
