<?php

namespace App\Services\ShoppingCart;

use App\Exceptions\ProductNotInShoppingCartException;
use App\Models\CouponCode;
use App\Models\Product;
use App\Models\ShoppingCart;
use Auth;
use DASPRiD\Enum\Exception\IllegalArgumentException;

class ShoppingCartService implements ShoppingCartServiceInterface
{

    /**
     * @throws IllegalArgumentException
     */
    function addProduct(Product $product, int $amount = 1): void
    {
        if ($amount <= 0 || $amount > config('shop.shopping_cart.max_product_amount')) throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        if ($this->hasShoppingCartProduct($product, -1)) {
            $cart_entry = ShoppingCart::whereProductId($product->id)->where('user_id', '=', Auth::user()->id)->get()->first();
            $cart_entry->count = $cart_entry->count + $amount;
            $cart_entry->save();
        } else {
            ShoppingCart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'count' => $amount,
            ]);
        }
    }

    /**
     * @throws IllegalArgumentException
     * @throws ProductNotInShoppingCartException
     */
    function removeProduct(Product $product, int $amount = 1): void
    {
        if (!$this->hasShoppingCartProduct($product, -1)) throw new ProductNotInShoppingCartException(__('exceptionMessages.product_not_in_shopping_cart'));
        if ($amount <= -1 || $amount === 0) throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        if ($amount === -1) $amount = $this->getAmountOfProduct($product);
        $product_amount = $this->getAmountOfProduct($product);
        $realAmount = $product_amount - $amount;
        $cart_entry = ShoppingCart::whereProductId($product->id)
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        if ($realAmount <= 0) {
            $cart_entry->count = 0;
        } else {
            $cart_entry->count = $cart_entry->count - $realAmount;
        }
        $cart_entry->save();
    }

    public function calculatePrice(bool $includeTaxes, CouponCode $coupon = null): float
    {
        $totalPrice = 0;
        $coupon_percentage = $coupon->code ?? 0;
        foreach (Auth::user()->shopping_cart() as $shopping_cart_entry) {
            $product = Product::whereId($shopping_cart_entry->product_id)->get()->first();
            $product_price = $product->price;
            $product_amount_in_shopping_cart = $this->getAmountOfProduct($product);
            $tax = $includeTaxes ? $product->tax : 0;
            $totalPrice += ($product_price * $product_amount_in_shopping_cart) * ((100 - $coupon_percentage) / 100) * ((100 + $tax) / 100);
        }
        return $totalPrice;
    }

    function calculatePriceOfProduct(Product $product, bool $includeTaxes): float
    {
        $product_price = $product->price;
        $product_amount_in_shopping_cart = $this->getAmountOfProduct($product);
        $tax = $includeTaxes ? $product->tax : 0;
        return ($product_price * $product_amount_in_shopping_cart) * ((100 + $tax) / 100);
    }

    /**
     * @throws IllegalArgumentException
     */
    function hasShoppingCartProduct(Product $product, int $amount = 0): bool
    {
        if ($amount < -1) throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        if ($amount === -1) return ShoppingCart::whereProductId($product->id)->where('user_id', '=', Auth::user()->id)->exists();
        return $this->getAmountOfProduct($product) === $amount;
    }

    function getAmountOfProduct(Product $product): int
    {
        return Auth::user()->shopping_cart()->where('product_id', '=', $product->id)->get()->count();
    }
}
