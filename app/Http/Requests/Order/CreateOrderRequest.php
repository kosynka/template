<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'address' => ['required', 'string', 'max:255'],
            'comment' => ['string', 'nullable'],
            'works_date' => ['required', 'date_format:Y-m-d'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image'],
            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'file'],
            'urgency_id' => ['required', 'integer', 'exists:urgencies,id'],
        ];
    }
}
