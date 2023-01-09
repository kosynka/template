<?php

namespace App\Http\Requests\User;

use App\Http\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:255'],
            'city_id' => ['exists:cities,id'],
            'business_type_id' => ['exists:business_types,id'],
            'phone' => [new Phone],
            'email' => ['email'],
            'photo' => ['file'],
        ];
    }
}
