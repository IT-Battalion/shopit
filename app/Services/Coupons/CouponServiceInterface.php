<?php

namespace App\Services\Coupons;

use App\Models\CouponCode;

interface CouponServiceInterface
{
    function isUsed($coupon_code): bool;
    function markAsUsed($coupon_code);
    function create($coupon_code, $discount, $enabled_until);
    function get($coupon_code): CouponCode;
}
