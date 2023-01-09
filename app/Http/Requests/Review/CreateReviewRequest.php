<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateReviewRequest extends FormRequest
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
        //TODO remove executor
        return [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'rate' => ['required', 'numeric', 'between:1,5'],
            'text' => ['string', 'nullable'],
        ];
    }
}
