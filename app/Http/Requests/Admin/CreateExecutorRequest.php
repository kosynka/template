<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Rules\Phone;

class CreateExecutorRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', new Phone],
            'city_id' => ['required', 'integer'],
            'photo_path' => ['nullable'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения',
            'email.required' => 'Поле "эл.почта" обязательно для заполнения',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
        ];
    }
}
