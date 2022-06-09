<?php

namespace App\Http\Requests;

use App\Types\AttributeType;
use App\Types\ClothingSize;
use App\Types\Liter;
use App\Types\Meter;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'name' => ['required', 'string', 'between:2,20', 'unique:products,name'],
            'price' => ['required', 'min:1'],
            'description' => ['required', 'string', 'min:10'],
            'highlighted' => ['required', 'boolean'],
            'category.id' => ['required', 'integer', 'exists:product_categories,id'],
            'images' => ['required', 'min:1', 'array'],
            'attributes' => ['array', 'between:-1,5'],
            'attributes.' . AttributeType::CLOTHING->value => ['present', 'array'],
            'attributes.' . AttributeType::VOLUME->value => ['present', 'array'],
            'attributes.' . AttributeType::DIMENSION->value => ['present', 'array'],
            'attributes.' . AttributeType::COLOR->value => ['present', 'array'],
            'attributes.' . AttributeType::CLOTHING->value . '.*.size' => ['required_with:attributes.clothing',new Enum(ClothingSize::class)],
            'attributes.' . AttributeType::VOLUME->value . '.*.volume.value' => ['required_with:attributes.volume','integer'],
            'attributes.' . AttributeType::VOLUME->value . '.*.volume.unit' => ['required_with:attributes.volume',Rule::in((new Liter(0))->getUnits())],
            'attributes.' . AttributeType::DIMENSION->value . '.*.width.value' => ['required_with:attributes.dimension','integer'],
            'attributes.' . AttributeType::DIMENSION->value . '.*.width.unit' => ['required_with:attributes.dimension',Rule::in((new Meter(0))->getUnits())],
            'attributes.' . AttributeType::DIMENSION->value . '.*.height.value' => ['required_with:attributes.dimension','integer'],
            'attributes.' . AttributeType::DIMENSION->value . '.*.height.unit' => ['required_with:attributes.dimension',Rule::in((new Meter(0))->getUnits())],
            'attributes.' . AttributeType::DIMENSION->value . '.*.depth.value' => ['required_with:attributes.dimension','integer'],
            'attributes.' . AttributeType::DIMENSION->value . '.*.depth.unit' => ['required_with:attributes.dimension',Rule::in((new Meter(0))->getUnits())],
            'attributes.' . AttributeType::COLOR->value . '.*.color' => ['required_with:attributes.color','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'attributes.' . AttributeType::COLOR->value . '.*.name' => ['required_with:attributes.color'],
        ];
    }
}
