<?php

namespace App\Http\Requests\Executor;

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
            'name' => ['string', 'max:255'],
            'phone' => [new Phone],
            'email' => ['email'],
            'city_id' => ['exists:cities,id'],
            'photo_path' => ['image'],
            'password' => ['required'],
        ];
    }
}
