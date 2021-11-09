<?php

namespace App\Services\Coupons;

use App\Models\CouponCode;
use Illuminate\Support\Carbon;

interface CouponServiceInterface
{
    /**
     * Returns if a CouponCode has been used or not.
     * @param string $coupon_code The Code of the Coupon
     * @return bool true if its used, false if it's not used.
     */
    function isUsed(string $coupon_code): bool;

    /**
     * Marks a Coupon as Used.
     * @param string $coupon_code The code of the Coupon
     */
    function markAsUsed(string $coupon_code): void;

    /**
     * Creates a new Coupon Code.
     * @param int $discount The discount of the Code (max 100)
     * @param Carbon $enabled_until The Date until the Code should be use able.
     * @param string|null $coupon_code The Code of the Coupon
     * @return CouponCode The created Coupon Code Model.
     */
    function create(int $discount, Carbon $enabled_until, string $coupon_code = null): CouponCode;

    /**
     * Return a CouponCode Model.
     * @param string $coupon_code The Code of the Coupon.
     * @return CouponCode The CouponCode Model.
     */
    function get(string $coupon_code): CouponCode;

    /**
     * Deletes a CouponCode.
     * @param string $coupon_code The Code of the Coupon.
     */
    function delete(string $coupon_code): void;
}
