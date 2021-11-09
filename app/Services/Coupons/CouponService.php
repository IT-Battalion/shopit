<?php

namespace App\Services\Coupons;

use App\Exceptions\CouponCodeDiscounOutOfBoundsException;
use App\Exceptions\CouponCodeNotFoundException;
use App\Models\CouponCode;
use Illuminate\Support\Carbon;
use Str;

class CouponService implements CouponServiceInterface
{

    /**
     * @throws CouponCodeDiscounOutOfBoundsException
     */
    function isUsed(string $coupon_code): bool
    {
        return !$this->get($coupon_code)->enabled;
    }

    /**
     * @throws CouponCodeNotFoundException
     */
    function get(string $coupon_code): CouponCode
    {
        $coupon = CouponCode::whereCode($coupon_code)->get();
        if ($coupon->count() === 0) throw new CouponCodeNotFoundException(__('exceptionMessages.coupon_code_not_found_exception'));
        return $coupon->first();
    }

    /**
     * @throws CouponCodeDiscounOutOfBoundsException
     */
    function create(int $discount, Carbon $enabled_until, string $coupon_code = null): CouponCode
    {
        if ($discount < 1 || $discount > 100) throw new CouponCodeDiscounOutOfBoundsException(__('exceptionMessages.coupon_code_discount_out_of_bounds'));
        return CouponCode::create([
            'code' => $coupon_code ?? Str::random(32),
            'discount' => $discount,
            'enabled_until' => $enabled_until,
        ]);
    }

    /**
     * @throws CouponCodeDiscounOutOfBoundsException
     */
    function delete(string $coupon_code): void
    {
        $this->get($coupon_code)->delete();
    }

    /**
     * @throws CouponCodeDiscounOutOfBoundsException
     */
    function markAsUsed(string $coupon_code): void
    {
        $coupon = $this->get($coupon_code);
        $coupon->enabled = false;
        $coupon->save();
    }
}
