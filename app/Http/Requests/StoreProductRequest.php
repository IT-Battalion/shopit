<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->enabled && Auth::user()->isAdmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'between:2,20', 'unique:products,name'],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'min:10'],
            'highlighted' => ['required', 'boolean'],
            'category.id' => ['required', 'integer', 'numeric', 'exists:product_categories,id'],
            'images' => ['required', 'min:1', 'array'],
            'attributes' => ['array', 'between:-1,5'],
            'attributes.clothing' => [Rule::requiredIf(function () {
                return 'attributes.clothing.enabled';
            })],
            'attributes.color' => [Rule::requiredIf(function () {
                return 'attributes.color.enabled';
            })],
            'attributes.volume' => [Rule::requiredIf(function () {
                return 'attributes.volume.enabled';
            })],
            'attributes.dimension' => [Rule::requiredIf(function () {
                return 'attributes.dimension.enabled';
            })],
            'attributes.clothing.value.size' => ['required_if:attributes.clothing.enabled,true'],
            'attributes.volume.value.volume' => ['required_if:attributes.volume.enabled,true'],
            'attributes.dimension.value.width' => ['required_if:attributes.dimension.enabled,true'],
            'attributes.dimension.value.height' => ['required_if:attributes.dimension.enabled,true'],
            'attributes.dimension.value.depth' => ['required_if:attributes.dimension.enabled,true'],
            'attributes.color.value.color.colors' => ['required_if:attributes.color.enabled,true'],
        ];
    }
}
