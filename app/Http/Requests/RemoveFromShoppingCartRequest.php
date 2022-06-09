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
            'count' => ['required', 'numeric', 'gte:-1'],
            'selectedAttributes' => ['array'],
            'selectedAttributes.*.id' => ['numeric'],
            'selectedAttributes.*.type' => ['numeric', 'between:0,3'],
        ];
    }

    public function getSelectedAttributes()
    {
        return collect($this['selectedAttributes'])
            ->mapWithKeys(function ($selectedAttribute) {
                return [
                    $selectedAttribute['type'] => $selectedAttribute['id'],
                ];
            });
    }
}
