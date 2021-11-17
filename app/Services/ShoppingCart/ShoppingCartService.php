<?php

namespace App\Services\ShoppingCart;

use App\Exceptions\ProductNotInShoppingCartException;
use App\Models\Product;
use DASPRiD\Enum\Exception\IllegalArgumentException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

// TODO: implement a service that helps handling orders
// TODO: not here but Tests for every relation between models to verify that they work
// TODO: add default constructors to every model class
class ShoppingCartService implements ShoppingCartServiceInterface
{

    /**
     * @throws IllegalArgumentException
     */
    public function addProduct(Product $product, int $amount = 1): void
    {
        if ($amount === 0)
        {
            return;
        }

        if ($amount < 0 || $amount > config('shop.shopping_cart.max_product_amount'))
        {
            throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        }

        if ($this->hasProductInShoppingCart($product)) {
            $previousAmount = $this->getAmountOfProduct($product);
            Auth::user()->shopping_cart()->updateExistingPivot($product, ['count' => $previousAmount + $amount]);
        } else {
            Auth::user()->shopping_cart()->attach($product, ['count' => $amount]);
        }
    }

    /**
     * @throws IllegalArgumentException
     * @throws ProductNotInShoppingCartException
     */
    public function removeProduct(Product $product, int $amount = -1): void
    {
        if ($amount === 0) {
            return;
        }

        if (!$this->hasProductInShoppingCart($product)) {
            throw new ProductNotInShoppingCartException(__('exceptionMessages.product_not_in_shopping_cart'));
        }

        if ($amount < -1) {
            throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        }

        if ($amount === -1) {
            Auth::user()->shopping_cart()->detach($product);
        }

        $previousAmount = $this->getAmountOfProduct($product);
        $newAmount = $previousAmount - $amount;

        if ($newAmount <= 0)
        {
            Auth::user()->shopping_cart()->detach($product);
        }

        Auth::user()->shopping_cart()->updateExistingPivot($product, ['count' => $newAmount]);
    }

    /**
     * @throws IllegalArgumentException
     */
    public function setProductAmount(Product $product, int $amount): void
    {
        if ($amount < 0)
        {
            throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        }

        if ($this->hasProductInShoppingCart($product))
        {
            if ($amount === 0)
            {
                Auth::user()->shopping_cart()->detach($product);
            }

            Auth::user()->shopping_cart()->updateExistingPivot($product, ['count' => $amount]);
        } else {
            if ($amount === 0)
            {
                return;
            }

            Auth::user()->shopping_cart()->attach($product, ['count' => $amount]);
        }
    }

    public function calculatePrice(bool $includeTax = true, bool $includeCoupon = true): float
    {
        $coupon = Auth::user()->shopping_cart_coupon;
        $discount = $coupon === null ? 0 : $coupon->discount;

        $price = Auth::user()->shopping_cart
            ->groupBy(function (Product $product) {
                return $product->tax*100; // can't just be the tax since it can't group by the decimal places of floats
            })
            ->reduce(function (mixed $carry, Collection $products, int $tax) use ($includeCoupon, $includeTax, $discount) {
                $price = $products->reduce(function (mixed $carry, Product $product) {
                    $netto = $product->price;
                    $amount = strval($product->pivot->count);
                    return bcadd($carry, bcmul($netto, $amount));
                });

                if ($includeCoupon)
                {
                    $price = bcmul($price, 1 - $discount);
                }

                if ($includeTax)
                {
                    $price = bcmul($price, 1 + $tax / 100);
                }

                return bcadd($carry, $price);
            });

        return floatval($price);
    }

    public function calculateTax(): float
    {
        $coupon = Auth::user()->shopping_cart_coupon;
        $discount = $coupon->discount ?? 0.0;

        $taxPrice = Auth::user()->shopping_cart
            ->groupBy(function (Product $product) {
                return $product->tax*100;
            })
            ->reduce(function (mixed $carry, Collection $products, int $tax) use ($discount) {
                $price = $products->reduce(function (mixed $carry, Product $product) {
                    $netto = $product->price;
                    $amount = strval($product->pivot->count);
                    return bcadd($carry, bcmul($netto, $amount));
                });

                $price = bcmul($price, 1 - $discount);

                $taxPrice = bcmul($price, $tax / 100.0);

                return bcadd($carry, $taxPrice);
            });

        return floatval($taxPrice);
    }

    public function calculateDiscount(): float
    {
        $coupon = Auth::user()->shopping_cart_coupon;
        $discount = $coupon->discount ?? 0.0;

        $discountPrice = Auth::user()->shopping_cart
            ->reduce(function (mixed $carry, Product $product) use ($discount) {
                $discount = bcmul(bcmul($product->price, $discount), $product->pivot->count);

                return bcadd($carry, $discount);
            });

        return floatval($discountPrice);
    }

    public function calculatePriceOfProduct(Product $product, bool $includeTaxes, bool $includeCoupon): float
    {
        $product_price = $product->price;
        $product_amount_in_shopping_cart = $this->getAmountOfProduct($product);
        $tax = $includeTaxes ? $product->tax : 0;
        $discount = $includeCoupon ? Auth::user()->shopping_cart_coupon->discount ?? 0.0 : 0.0;
        return $product_price * $product_amount_in_shopping_cart * (1 - $discount) * (1 + $tax);
    }

    /**
     * @throws IllegalArgumentException
     */
    public function hasProductInShoppingCart(Product $product, int $amount = -1): bool
    {
        if ($amount < -1) throw new IllegalArgumentException(__('exceptionMessages.illegal_amount_given'));
        if ($amount === -1) return Auth::user()->shopping_cart()->wherePivot('product_id', $product->id)->count() !== 0;
        return $this->getAmountOfProduct($product) === $amount;
    }

    public function getAmountOfProduct(Product $product): int
    {
        if (Auth::user()->shopping_cart()->wherePivot('product_id', $product->id)->count() === 0)
        {
            return 0;
        }
        return Auth::user()->shopping_cart()->find($product)->pivot->count;
    }
}