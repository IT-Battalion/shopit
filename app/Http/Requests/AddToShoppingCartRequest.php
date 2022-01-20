<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddToShoppingCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->enabled;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'exists:products'],
            'count' => ['required', 'integer', 'numeric', 'gt:0'],
            'selected_attributes' => ['required', 'array'],
            'selected_attributes.*.id' => ['numeric'],
            'selected_attributes.*.type' => ['numeric', 'between:0,3'],
        ];
    }

}
