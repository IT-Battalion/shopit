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
     * @param int $amount The Amount which should be removed from the Shopping Cart. If -1 all will be removed.
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

    /**
     * Checks if the Shopping Cart has a specific Product or an Amount of a specific Product.
     * @param Product $product The Product which should be searched for.
     * @param int $amount The Amount of the Product which should be checked. Default 0.
     * @return bool true if the Product is existing and the amount matches. Else false.
     */
    function hasShoppingCartProduct(Product $product, int $amount = 0): bool;

    /**
     * Returns the Amount of a Product in a Shopping Cart.
     * @param Product $product The Product which should be searched for.
     * @return int The Amount of the Product in the Shopping Cart.
     */
    function getAmountOfProduct(Product $product): int;
}
