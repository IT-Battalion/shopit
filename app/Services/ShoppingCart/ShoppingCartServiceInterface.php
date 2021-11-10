<?php

namespace App\Services\ShoppingCart;

use App\Models\CouponCode;
use App\Models\Product;

interface ShoppingCartServiceInterface
{
    /**
     * Adds a Product into the Shopping Cart of a User.
     * @param Product $product The Product which should be added to the Shopping Cart.
     * @param int $amount The Amount which should be added to the Shopping Cart.
     */
    function addProduct(Product $product, int $amount = 1): void;

    /**
     * Removes a Product from the Shopping Cart of a User.
     * @param Product $product The Product which should be removed from the Shopping Cart.
     * @param int $amount The Amount which should be removed from the Shopping Cart.
     */
    function removeProduct(Product $product, int $amount = 1): void;

    /**
     * Calculates the total price of the Shopping Cart.
     * @param bool $includeTaxes Calculate taxes into the price or not.
     * @param CouponCode|null $coupon null if no CouponCode was applied, otherwise the Coupon.
     * @return float the price in EUR
     */
    function calculatePrice(bool $includeTaxes, CouponCode $coupon = null): float;

    /**
     * Calculates the total Price of a Product from the Shopping Cart (usually more than one)
     * @param Product $product The Product of which the total price should be calculated. (usually more than one)
     * @param bool $includeTaxes If Taxes should be included.
     * @return float The total price in EUR.
     */
    function calculatePriceOfProduct(Product $product, bool $includeTaxes): float;
}
