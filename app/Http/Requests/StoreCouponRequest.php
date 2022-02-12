<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'code' => ['required', 'string', 'unique:coupon_codes', 'min:6'],
            'discount' => ['required', 'numeric', 'integer', 'between:0,100'],
            'enabled_until' => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:' . date('yyyy-MM-dd')],
        ];
    }
}
