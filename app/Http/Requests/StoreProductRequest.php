<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required | max:255',
            'price' => 'required | numeric',
            'discountType' => [
                'required',
                Rule::in(['amount', 'percent']),
            ],
            'discountValue' => [
                'required'
            ],
            'images' => ['required' , 'array', 'min:4']
        ];
    }
}
