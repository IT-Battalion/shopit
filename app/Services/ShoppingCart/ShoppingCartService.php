<?php

namespace App\Services\ShoppingCart;

use App\Exceptions\InvalidAttributeException;
use App\Models\Product;
use App\Models\User;
use App\Types\AttributeType;
use DASPRiD\Enum\Exception\IllegalArgumentException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ShoppingCartService implements ShoppingCartServiceInterface
{

    /**
     * @throws IllegalArgumentException
     * @throws InvalidAttributeException
     */
    public function addProduct(Product $product, Collection $attributes, int $amount = 1, User $user = null): void
    {
        if ($amount === 0)
        {
            return;
        }

        if ( ! $product->areAttributesAvailable($attributes))
        {
            throw new InvalidAttributeException(t('exceptions.selected_attribute_not_available'));
        }

        $user = $user ?? Auth::user();
        $previousAmount = $this->getAmountOfProduct($product, $attributes, user: $user);
        $newAmount = $previousAmount + $amount;

        if ($amount < 0 || $newAmount > config('shop.shopping_cart.max_product_amount'))
        {
            throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
        }

        if ($this->hasProductInShoppingCart($product, $attributes, user: $user))
        {
            self::getProductInShoppingCartQuery($product, $attributes, $user)->updateExistingPivot($product, [
                'count' => $newAmount,
            ]);
        } else {
            self::addProductToShoppingCart($newAmount, $attributes, $user, $product);
        }
    }

    /**
     * @throws IllegalArgumentException
     */
    public function removeProduct(Product $product, Collection $attributes, int $amount = -1, User $user = null): void
    {
        if ($amount === 0) {
            return;
        }

        if ( ! $product->areAttributesAvailable($attributes))
        {
            return;
        }

        $user = $user ?? Auth::user();

        if ( ! $this->hasProductInShoppingCart($product, $attributes, user: $user)) {
            return;
        }

        if ($amount < -1) {
            throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
        }

        if ($amount === -1) {
            self::getProductInShoppingCartQuery($product, $attributes, $user)->detach($product);
            return;
        }

        $previousAmount = $this->getAmountOfProduct($product, $attributes, user: $user);
        $newAmount = $previousAmount - $amount;

        if ($newAmount > config('shop.shopping_cart.max_product_amount'))
        {
            throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
        }
        else if ($newAmount <= 0)
        {
            self::getProductInShoppingCartQuery($product, $attributes, $user)->detach($product);
        } else {
            self::getProductInShoppingCartQuery($product, $attributes, $user)->updateExistingPivot($product, ['count' => $newAmount]);
        }
    }

    /**
     * @throws IllegalArgumentException
     * @throws InvalidAttributeException
     */
    public function setProductAmount(Product $product, Collection $attributes, int $amount, User $user = null): void
    {
        if ($amount < 0)
        {
            throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
        }

        if ( ! $product->areAttributesAvailable($attributes))
        {
            throw new InvalidAttributeException(t('exceptions.selected_attribute_not_available'));
        }

        $user = $user ?? Auth::user();

        if ($this->hasProductInShoppingCart($product, $attributes))
        {
            if ($amount === 0)
            {
                self::getProductInShoppingCartQuery($product, $attributes, $user)->detach($product);
            }

            self::getProductInShoppingCartQuery($product, $attributes, $user)->updateExistingPivot($product, ['count' => $amount]);
        } else {
            if ($amount === 0)
            {
                return;
            }

            $this->addProductToShoppingCart($amount, $attributes, $user, $product);
        }
    }

    public function calculatePrice(bool $includeTax = true, bool $includeCoupon = true, User $user = null): float
    {
        $user = $user ?? Auth::user();

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
        $user = $user ?? Auth::user();

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
        $user = $user ?? Auth::user();

        $coupon = $user->shopping_cart_coupon;
        $discount = $coupon->discount ?? 0.0;

        $discountPrice = $user->shopping_cart
            ->reduce(function (mixed $carry, Product $product) use ($discount) {
                $discount = bcmul(bcmul($product->price, $discount), $product->pivot->count);

                return bcadd($carry, $discount);
            });

        return floatval($discountPrice);
    }

    public function calculatePriceOfProduct(Product $product, Collection $attributes, bool $includeTaxes, bool $includeCoupon, User $user = null): float
    {
        $user = $user ?? Auth::user();

        $product_price = $product->price;
        $product_amount_in_shopping_cart = $this->getAmountOfProduct($product, $attributes);
        $tax = $includeTaxes ? $product->tax : 0;
        $discount = $includeCoupon ? $user->shopping_cart_coupon->discount ?? 0.0 : 0.0;
        return $product_price * $product_amount_in_shopping_cart * (1 - $discount) * (1 + $tax);
    }

    /**
     * @throws IllegalArgumentException
     */
    public function hasProductInShoppingCart(Product $product, Collection $attributes, int $amount = -1, User $user = null): bool
    {
        $user = $user ?? Auth::user();

        if ($amount < -1)
        {
            throw new IllegalArgumentException(t('error_messages.illegal_amount_given'));
        }

        $productInShoppingCart = self::getProductInShoppingCartQuery($product, $attributes, $user);

        if ($amount === -1) {
            return $productInShoppingCart
                    ->count() !== 0;
        }

        return $this->getAmountOfProduct($product, $attributes) === $amount;
    }

    public function getAmountOfProduct(Product $product, Collection $attributes, User $user = null): int
    {
        $user = $user ?? Auth::user();

        $productInShoppingCart = self::getProductInShoppingCartQuery($product, $attributes, $user);

        if ($productInShoppingCart->count() === 0)
        {
            return 0;
        }

        return $productInShoppingCart
            ->get()->first()
            ->pivot->count;
    }

    private static function getProductInShoppingCartQuery(Product $product, Collection $attributes, User $user = null): BelongsToMany
    {
        $user = $user ?? Auth::user();

        $shopping_cart = $user->shopping_cart();

        foreach (AttributeType::getValues() as $type) {
            $type = new AttributeType($type);
            $shopping_cart = $shopping_cart
                ->wherePivot('product_' . strtolower($type->key) . '_attribute_id', $attributes->get($type->value));
        }

        return $shopping_cart
            ->wherePivot('product_id', $product->id);
    }

    /**
     * @param int $newAmount
     * @param Collection $attributes
     * @param User|null $user
     * @param Product $product
     * @return void
     * @throws InvalidAttributeException
     */
    private function addProductToShoppingCart(int $newAmount, Collection $attributes, User|null $user, Product $product): void
    {
        if ( ! $product->areAttributesAvailable($attributes))
        {
            throw new InvalidAttributeException(t('exceptions.selected_attribute_not_available'));
        }

        $newAttributes = ['count' => $newAmount];

        foreach (AttributeType::getValues() as $type) {
            if ( ! $attributes->has($type)) {
                continue;
            }

            $type = new AttributeType($type);
            $newAttributes['product_' . strtolower($type->key) . '_attribute_id'] = $attributes->get($type->value);
        }

        $user->shopping_cart()
            ->attach($product, $newAttributes);
    }
}
