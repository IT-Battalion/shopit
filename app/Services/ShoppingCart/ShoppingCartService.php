<?php

namespace App\Services\ShoppingCart;

use App\Exceptions\ProductNotInShoppingCartException;
use App\Models\Money;
use App\Models\Product;
use App\Models\User;
use DASPRiD\Enum\Exception\IllegalArgumentException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ShoppingCartService implements ShoppingCartServiceInterface
{

    /**
     * @throws IllegalArgumentException
     */
    public function addProduct(Product $product, int $amount = 1, User $user = null): void
    {
        if ($amount === 0)
        {
            return;
        }

        $user = $user ?? Auth::user();

        if ($amount < 0 || $amount > config('shop.shopping_cart.max_product_amount'))
        {
            throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        }

        if ($this->hasProductInShoppingCart($product, user: $user)) {
            $previousAmount = $this->getAmountOfProduct($product, user: $user);
            $user->shopping_cart()->updateExistingPivot($product, ['count' => $previousAmount + $amount]);
        } else {
            $user->shopping_cart()->attach($product, ['count' => $amount]);
        }
    }

    /**
     * @throws IllegalArgumentException
     * @throws ProductNotInShoppingCartException
     */
    public function removeProduct(Product $product, int $amount = -1, User $user = null): void
    {
        if ($amount === 0) {
            return;
        }

        $user = $user ?? Auth::user();

        if (!$this->hasProductInShoppingCart($product, user: $user)) {
            throw new ProductNotInShoppingCartException(__('exceptionMessages.product_not_in_shopping_cart'));
        }

        if ($amount < -1) {
            throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        }

        if ($amount === -1) {
            $user->shopping_cart()->detach($product);
            return;
        }

        $previousAmount = $this->getAmountOfProduct($product, user: $user);
        $newAmount = $previousAmount - $amount;

        if ($newAmount <= 0)
        {
            $user->shopping_cart()->detach($product);
        } else {
            $user->shopping_cart()->updateExistingPivot($product, ['count' => $newAmount]);
        }

    }

    /**
     * @throws IllegalArgumentException
     */
    public function setProductAmount(Product $product, int $amount, User $user = null): void
    {
        if ($amount < 0)
        {
            throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        }

        $user = $user ?? Auth::user();

        if ($this->hasProductInShoppingCart($product))
        {
            if ($amount === 0)
            {
                $user->shopping_cart()->detach($product);
            }

            $user->shopping_cart()->updateExistingPivot($product, ['count' => $amount]);
        } else {
            if ($amount === 0)
            {
                return;
            }

            $user->shopping_cart()->attach($product, ['count' => $amount]);
        }
    }

    public function calculatePrice(bool $includeTax = true, bool $includeCoupon = true, User $user = null): Money
    {
        $user = $user ?? Auth::user();

        $coupon = $user->shopping_cart_coupon;
        $discount = $coupon->discount ?? '0';

        $price = $user->shopping_cart
            ->groupBy(function (Product $product) {
                return $product->tax;
            })
            ->reduce(function (Money $carry, Collection $products, string $tax) use ($includeCoupon, $includeTax, $discount) {
                $price = $products->reduce(function (Money $carry, Product $product) {
                    $netto = $product->price;
                    $amount = $product->pivot->count;
                    return $carry->add($netto->mul($amount));
                }, new Money('0'));

                if ($includeCoupon)
                {
                    $price->mul(bcsub(1, $discount));
                }

                if ($includeTax)
                {
                    $price->mul(bcadd('1', $tax));
                }

                return $carry->add($price);
            }, new Money('0'));

        return $price;
    }

    public function calculateTax(User $user = null): Money
    {
        $user = $user ?? Auth::user();

        $coupon = $user->shopping_cart_coupon;
        $discount = $coupon->discount ?? '0';

        $taxPrice = $user->shopping_cart
            ->groupBy(function (Product $product) {
                return $product->tax;
            })
            ->reduce(function (Money $carry, Collection $products, string $tax) use ($discount) {
                $price = $products->reduce(function (Money $carry, Product $product) {
                    $netto = $product->price;
                    $amount = $product->pivot->count;
                    return $carry->add($netto->mul($amount));
                }, new Money('0'));

                $price->mul(bcsub(1, $discount));

                $taxPrice = $price->mul($tax);

                return $carry->add($taxPrice);
            }, new Money('0'));

        return $taxPrice;
    }

    public function calculateDiscount(User $user = null): Money
    {
        $user = $user ?? Auth::user();

        $coupon = $user->shopping_cart_coupon;
        $discount = $coupon->discount ?? '0';

        $discountPrice = $user->shopping_cart
            ->reduce(function (Money $carry, Product $product) use ($discount) {
                $discount = $product->price->mul($product->pivot->count, $discount);

                return $carry->add($discount);
            }, new Money('0'));

        return $discountPrice;
    }

    public function calculatePriceOfProduct(Product $product, bool $includeTaxes, bool $includeCoupon, User $user = null): Money
    {
        $user = $user ?? Auth::user();

        $product_price = $product->price;
        $product_amount_in_shopping_cart = $this->getAmountOfProduct($product);
        $tax = $includeTaxes ? $product->tax : '0';
        $discount = $includeCoupon ? $user->shopping_cart_coupon->discount ?? '0' : '0';
        return $product_price->mul($product_amount_in_shopping_cart, bcsub(1, $discount), bcadd(1, $tax));
    }

    /**
     * @throws IllegalArgumentException
     */
    public function hasProductInShoppingCart(Product $product, int $amount = -1, User $user = null): bool
    {
        $user = $user ?? Auth::user();

        if ($amount < -1) throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        if ($amount === -1) return $user->shopping_cart()->wherePivot('product_id', $product->id)->count() !== 0;
        return $this->getAmountOfProduct($product) === $amount;
    }

    public function getAmountOfProduct(Product $product, User $user = null): int
    {
        $user = $user ?? Auth::user();

        if ($user->shopping_cart()->wherePivot('product_id', $product->id)->count() === 0)
        {
            return 0;
        }
        return $user->shopping_cart()->find($product)->pivot->count;
    }
}
