<?php

namespace App\Services\ShoppingCart;

use App\Models\Product;
use App\Models\User;

interface ShoppingCartServiceInterface
{
    /**
     * Adds a Product into the Shopping Cart of a User.
     * @param Product $product The Product which should be added to the Shopping Cart.
     * @param int $amount The Amount which should be added to the Shopping Cart.
     */
    public function addProduct(Product $product, int $amount = 1, User $user = null): void;

    /**
     * Removes products from the shopping cart of a user.
     * Per default all of a certain product will be removed from the shopping cart.
     * @param Product $product The Product which should be removed from the Shopping Cart.
     * @param int $amount The Amount which should be removed from the Shopping Cart. If -1 all will be removed.
     */
    public function removeProduct(Product $product, int $amount = -1, User $user = null): void;

    /**
     * Sets the amount of a product in the shopping cart
     * @param Product $product The product of a specified amount should exist in the shopping cart
     * @param int $amount How much of a given Product should be in the shopping cart
     */
    public function setProductAmount(Product $product, int $amount, User $user = null): void;

    /**
     * Calculates the total price of the Shopping Cart.
     * @param bool $includeTax whether to include taxes or not
     * @param bool $includeCoupon whether to include the coupon or not
     * @return float the price in EUR
     */
    public function calculatePrice(bool $includeTax = true, bool $includeCoupon = true, User $user = null): float;

    /**
     * Calculates the amount of tax on the shopping cart of teh authenticated user
     * @return float the tax in EUR
     */
    public function calculateTax(User $user = null): float;

    /**
     * Calculates the discount applied by a coupon
     * @return float the discount in EUR
     */
    public function calculateDiscount(User $user = null): float;

    /**
     * Calculates the total Price of a Product from the Shopping Cart (usually more than one)
     * @param Product $product The Product of which the total price should be calculated. (usually more than one)
     * @param bool $includeTaxes If Taxes should be included.
     * @param bool $includeCoupon Whether the coupon currently in use should be applied
     * @return float The total price in EUR.
     */
    public function calculatePriceOfProduct(Product $product, bool $includeTaxes, bool $includeCoupon, User $user = null): float;

    /**
     * Checks if the Shopping Cart has a specific Product or an Amount of a specific Product.
     * If the amount is -1 (default) any amount of that product counts.
     * @param Product $product The Product which should be searched for.
     * @param int $amount The Amount of the Product which should be checked. Default -1.
     * @return bool true if the Product is existing and the amount matches. Else false.
     */
    public function hasProductInShoppingCart(Product $product, int $amount = -1, User $user = null): bool;

    /**
     * Returns the Amount of a Product in a Shopping Cart.
     * @param Product $product The Product which should be searched for.
     * @return int The Amount of the Product in the Shopping Cart.
     */
    public function getAmountOfProduct(Product $product, User $user = null): int;
}
