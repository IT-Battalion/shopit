<?php

namespace App\Services\ShoppingCart;

use App\Models\Product;
use App\Models\User;
use App\Types\Money;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

interface ShoppingCartServiceInterface
{
    /**
     * Adds a Product into the Shopping Cart of a User.
     * @param Product $product The Product which should be added to the Shopping Cart.
     * @param Collection $attributes the product's attributes (color, size, ...)
     * @param int $amount The Amount which should be added to the Shopping Cart.
     * @param User|null $user the shopping cart's owner
     */
    public function addProduct(Product $product, Collection $attributes, int $amount = 1, User $user = null): void;

    /**
     * Removes products from the shopping cart of a user.
     * Per default all of a certain product will be removed from the shopping cart.
     * @param Product $product The Product which should be removed from the Shopping Cart.
     * @param Collection $attributes the product's attributes (color, size, ...)
     * @param int $amount The Amount which should be removed from the Shopping Cart. If -1 all will be removed.
     * @param User|null $user the shopping cart's owner
     */
    public function removeProduct(Product $product, Collection $attributes, int $amount = -1, User $user = null): void;

    /**
     * Sets the amount of a product in the shopping cart
     * @param Product $product The product of a specified amount should exist in the shopping cart
     * @param Collection $attributes the product's attributes (color, size, ...)
     * @param int $amount How much of a given Product should be in the shopping cart
     * @param User|null $user the shopping cart's owner
     */
    public function setProductAmount(Product $product, Collection $attributes, int $amount, User $user = null): void;

    /**
     * Calculates the total price of the Shopping Cart.
     * @param bool $includeTax whether to include taxes or not
     * @param bool $includeCoupon whether to include the coupon or not
     * @return Money the price in EUR
     */
    public function calculatePrice(bool $includeTax = true, bool $includeCoupon = true, User $user = null): Money;

    /**
     * Calculates the amount of tax on the shopping cart of teh authenticated user
     * @return Money the tax in EUR
     */
    public function calculateTax(User $user = null): Money;

    /**
     * Calculates the discount applied by a coupon
     * @return Money the discount in EUR
     */
    public function calculateDiscount(User $user = null): Money;

    /**
     * Calculates various prices for a shopping cart including:
     *  - [type (name)]
     *  - gross price (subtotal)
     *  - discount (discount)
     *  - tax (tax)
     *  - total with discount and tax (total)
     * @param User|null $user
     * @return array
     */
    #[ArrayShape(['subtotal' => "\App\Types\Money", 'tax' => "\App\Types\Money", 'discount' => "\App\Types\Money", 'total' => "\App\Types\Money"])]
    public function calculateShoppingCartPrice(User $user = null): array;

    /**
     * Calculates the total Price of a Product from the Shopping Cart (usually more than one)
     * @param Product $product The Product of which the total price should be calculated. (usually more than one)
     * @param Collection $attributes the product's attributes (color, size, ...)
     * @param bool $includeTaxes If Taxes should be included.
     * @param bool $includeCoupon Whether the coupon currently in use should be applied
     * @param User|null $user the shopping cart's owner
     * @return Money The total price in EUR.
     */
    public function calculatePriceOfProduct(Product $product, Collection $attributes, bool $includeTaxes, bool $includeCoupon, User $user = null): Money;

    /**
     * Checks if the Shopping Cart has a specific Product or an Amount of a specific Product.
     * If the amount is -1 (default) any amount of that product counts.
     * @param Product $product The Product which should be searched for.
     * @param Collection $attributes the product's attributes (color, size, ...)
     * @param int $amount The Amount of the Product which should be checked. Default -1.
     * @param User|null $user the shopping cart's owner
     * @return bool true if the Product is existing and the amount matches. Else false.
     */
    public function hasProductInShoppingCart(Product $product, Collection $attributes, int $amount = -1, User $user = null): bool;

    /**
     * Returns the Amount of a Product in a Shopping Cart.
     * @param Product $product The Product which should be searched for.
     * @param Collection $attributes the product's attributes (color, size, ...)
     * @param User|null $user the shopping cart's owner
     * @return int The Amount of the Product in the Shopping Cart.
     */
    public function getAmountOfProduct(Product $product, Collection $attributes, User $user = null): int;
}
