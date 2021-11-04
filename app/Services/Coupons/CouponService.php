<?php

namespace App\Services\Coupons;

use App\Models\CouponCode;
use Illuminate\Support\Facades\Auth;

class CouponService implements CouponServiceInterface
{

    function isUsed($coupon_code): bool
    {
       return !$this->get($coupon_code)->enabled;
    }

    function markAsUsed($coupon_code)
    {
        $coupon = $this->get($coupon_code);
        $coupon->enabled = true;
        $coupon->updateWith(Auth::user());
        $coupon->save();
    }

    function get($coupon_code): CouponCode
    {
        return CouponCode::whereCode($coupon_code)->firstOrFail();
    }

    function create($coupon_code, $discount, $enabled_until)
    {
        CouponCode::create([
            'code' => $coupon_code,
            'discount' => $discount,
            'enabled_until' => $enabled_until,
            'created_by' => Auth::user()->id,
        ]);
    }
}
