<?php

namespace App\Services\ShoppingCart;

use App\Exceptions\ProductNotInShoppingCartException;
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

        if (is_null($user))
        {
            $user = Auth::user();
        }

        if ($amount < 0 || $amount > config('shop.shopping_cart.max_product_amount'))
        {
            throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
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

        if (is_null($user))
        {
            $user = Auth::user();
        }

        if (!$this->hasProductInShoppingCart($product, user: $user)) {
            throw new ProductNotInShoppingCartException(t('error_messages.product_not_in_shopping_cart'));
        }

        if ($amount < -1) {
            throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
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
            throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
        }

        if (is_null($user))
        {
            $user = Auth::user();
        }

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

    public function calculatePrice(bool $includeTax = true, bool $includeCoupon = true, User $user = null): float
    {
        if (is_null($user))
        {
            $user = Auth::user();
        }

        $coupon = $user->shopping_cart_coupon;
        $discount = $coupon === null ? 0 : $coupon->discount;

        $price = $user->shopping_cart
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

    public function calculateTax(User $user = null): float
    {
        if (is_null($user))
        {
            $user = Auth::user();
        }

        $coupon = $user->shopping_cart_coupon;
        $discount = $coupon->discount ?? 0.0;

        $taxPrice = $user->shopping_cart
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

    public function calculateDiscount(User $user = null): float
    {
        if (is_null($user))
        {
            $user = Auth::user();
        }

        $coupon = $user->shopping_cart_coupon;
        $discount = $coupon->discount ?? 0.0;

        $discountPrice = $user->shopping_cart
            ->reduce(function (mixed $carry, Product $product) use ($discount) {
                $discount = bcmul(bcmul($product->price, $discount), $product->pivot->count);

                return bcadd($carry, $discount);
            });

        return floatval($discountPrice);
    }

    public function calculatePriceOfProduct(Product $product, bool $includeTaxes, bool $includeCoupon, User $user = null): float
    {
        if (is_null($user))
        {
            $user = Auth::user();
        }

        $product_price = $product->price;
        $product_amount_in_shopping_cart = $this->getAmountOfProduct($product);
        $tax = $includeTaxes ? $product->tax : 0;
        $discount = $includeCoupon ? $user->shopping_cart_coupon->discount ?? 0.0 : 0.0;
        return $product_price * $product_amount_in_shopping_cart * (1 - $discount) * (1 + $tax);
    }

    /**
     * @throws IllegalArgumentException
     */
    public function hasProductInShoppingCart(Product $product, int $amount = -1, User $user = null): bool
    {
        if (is_null($user))
        {
            $user = Auth::user();
        }

        if ($amount < -1) throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
        if ($amount === -1) return $user->shopping_cart()->wherePivot('product_id', $product->id)->count() !== 0;
        return $this->getAmountOfProduct($product) === $amount;
    }

    public function getAmountOfProduct(Product $product, User $user = null): int
    {
        if (is_null($user))
        {
            $user = Auth::user();
        }

        if ($user->shopping_cart()->wherePivot('product_id', $product->id)->count() === 0)
        {
            return 0;
        }
        return $user->shopping_cart()->find($product)->pivot->count;
    }
}
