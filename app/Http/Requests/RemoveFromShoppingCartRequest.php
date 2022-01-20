<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RemoveFromShoppingCartRequest extends FormRequest
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
            'selected_attributes.*.type' => ['required', 'integer', 'numeric', 'between:0,3'],
            'selected_attributes.0.size' => ['required', 'integer', 'numeric', 'between:0,4'],
            'selected_attributes.1.width' => ['required', 'integer', 'numeric', 'gt:0'],
            'selected_attributes.1.height' => ['required', 'integer', 'numeric', 'gt:0'],
            'selected_attributes.1.depth' => ['required', 'integer', 'numeric', 'gt:0'],
            'selected_attributes.2.volume' => ['required', 'integer', 'numeric', 'gt:0'],
            'selected_attributes.3.name' => ['required', 'string'],
            'selected_attributes.3.color' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'selected_attributes' => json_decode($this->selected_attributes, true),
        ]);
    }

}
