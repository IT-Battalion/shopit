<?php

namespace App\Services\ShoppingCart;

use App\Exceptions\IllegalArgumentException;
use App\Exceptions\InvalidAttributeException;
use App\Models\Product;
use App\Models\User;
use App\Types\AttributeType;
use App\Types\Money;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class ShoppingCartService implements ShoppingCartServiceInterface
{

    /**
     * @throws IllegalArgumentException
     * @throws InvalidAttributeException
     */
    public function addProduct(Product $product, Collection $attributes, int $amount = 1, User $user = null): int
    {
        if ($amount === 0)
        {
            return 0;
        }

        if ( ! $product->areAttributesAvailable($attributes))
        {
            throw new InvalidAttributeException('Die gewählten Attribute sind nicht verfügbar.');
        }

        $user = $user ?? Auth::user();
        $previousAmount = $this->getAmountOfProduct($product, $attributes, user: $user);
        $newAmount = $previousAmount + $amount;

        if ($amount < 0 || $newAmount > config('shop.shopping_cart.max_product_amount'))
        {
            throw new IllegalArgumentException('Die gewählte Anzahl an Produkten ist nicht verfügbar.');
        }

        if ($this->hasProductInShoppingCart($product, $attributes, user: $user))
        {
            self::getProductInShoppingCartQuery($product, $attributes, $user)->updateExistingPivot($product, [
                'count' => $newAmount,
            ]);
        } else {
            self::addProductToShoppingCart($newAmount, $attributes, $user, $product);
        }
        return $newAmount;
    }

    /**
     * @throws IllegalArgumentException
     */
    public function removeProduct(Product $product, Collection $attributes, int $amount = -1, User $user = null): int
    {
        if ($amount === 0) {
            return 0;
        }

        if ( ! $product->areAttributesAvailable($attributes))
        {
            return 0;
        }

        $user = $user ?? Auth::user();

        if ( ! $this->hasProductInShoppingCart($product, $attributes, user: $user)) {
            return 0;
        }

        if ($amount < -1) {
            throw new IllegalArgumentException('Die gewählte Anzahl an Produkten ist nicht verfügbar.');
        }

        if ($amount === -1) {
            self::getProductInShoppingCartQuery($product, $attributes, $user)->detach($product);
            return 0;
        }

        $previousAmount = $this->getAmountOfProduct($product, $attributes, user: $user);
        $newAmount = $previousAmount - $amount;

        if ($newAmount > config('shop.shopping_cart.max_product_amount'))
        {
            throw new IllegalArgumentException('Die gewählte Anzahl an Produkten ist nicht verfügbar.');
        }
        else if ($newAmount <= 0)
        {
            self::getProductInShoppingCartQuery($product, $attributes, $user)->detach($product);
        } else {
            self::getProductInShoppingCartQuery($product, $attributes, $user)->updateExistingPivot($product, ['count' => $newAmount]);
        }
        return $newAmount;
    }

    /**
     * @throws IllegalArgumentException
     * @throws InvalidAttributeException
     */
    public function setProductAmount(Product $product, Collection $attributes, int $amount, User $user = null): void
    {
        if ($amount < 0)
        {
            throw new IllegalArgumentException('Die gewählte Anzahl an Produkten ist nicht verfügbar.');
        }

        if ( ! $product->areAttributesAvailable($attributes))
        {
            throw new InvalidAttributeException('Die gewählten Attribute sind nicht verfügbar.');
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

    public function calculatePrice(bool $includeTax = true, bool $includeCoupon = true, User $user = null): Money
    {
        $user = $user ?? Auth::user();

        $coupon = $user->coupon;
        $discount = $coupon?->discount ?? '0';

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

                if ($includeTax)
                {
                    $price = $price->mul(bcadd('1', $tax));
                }

                return $carry->add($price);
            }, new Money('0'));

        if ($includeCoupon)
        {
            $price = $price->mul(bcsub('1', $discount));
        }

        return $price;
    }

    public function calculateTax(User $user = null): Money
    {
        $user = $user ?? Auth::user();

        $coupon = $user->coupon;
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

                $price = $price->mul(bcsub('1', $discount));

                $taxPrice = $price->mul($tax);

                return $carry->add($taxPrice);
            }, new Money('0'));

        return $taxPrice;
    }

    public function calculateDiscount(User $user = null): Money
    {
        $user = $user ?? Auth::user();

        $coupon = $user->coupon;
        $discount = $coupon->discount ?? '0';

        $discountPrice = $user->shopping_cart
            ->reduce(function (Money $carry, Product $product) use ($discount) {
                $discount = $product->price->mul($product->pivot->count, $discount);

                return $carry->add($discount);
            }, new Money('0'));

        return $discountPrice;
    }

    /**
     * @param User|null $user
     * @return array
     */
    #[ArrayShape(['subtotal' => "\App\Types\Money", 'tax' => "\App\Types\Money", 'discount' => "\App\Types\Money", 'total' => "\App\Types\Money"])]
    public function calculateShoppingCartPrice(User $user = null): array
    {
        $user = $user ?? Auth::user();
        $discount = $user?->coupon->discount ?? '0';

        $taxPrices = $user->shopping_cart()->lazy()->reduce(function (array $carry, Product $product) {
            if (!isset($carry[$product->tax])) {
                $carry[$product->tax] = new Money('0');
            }
            $carry[$product->tax] = $carry[$product->tax]->add($product->price->mul($product->pivot->count));
            return $carry;
        }, []);

        $subtotal = new Money('0');
        $totalTax = new Money('0');

        foreach ($taxPrices as $tax => $price) {
            $subtotal = $subtotal->add($price);
            $totalTax = $totalTax->add($price->mul($tax,'1'));
        }

        $totalDiscount = $subtotal->mul($discount);
        $totalTax = $totalTax->mul(bcsub('1', $discount));
        $total = $subtotal->sub($totalDiscount)->add($totalTax);

        return [
            'subtotal' => $subtotal,
            'tax' => $totalTax,
            'discount' => $totalDiscount,
            'total' => $total,
        ];
    }


    public function calculatePriceOfProduct(Product $product, Collection $attributes, bool $includeTaxes, bool $includeCoupon, User $user = null): Money
    {
        $user = $user ?? Auth::user();

        $product_price = $product->price;
        $product_amount_in_shopping_cart = $this->getAmountOfProduct($product, $attributes);
        $tax = $includeTaxes ? $product->tax : '0';
        $discount = $includeCoupon ? $user->coupon->discount ?? '0' : '0';
        return $product_price->mul($product_amount_in_shopping_cart, bcsub(1, $discount), bcadd(1, $tax));
    }

    /**
     * @throws IllegalArgumentException
     */
    public function hasProductInShoppingCart(Product $product, Collection $attributes, int $amount = -1, User $user = null): bool
    {
        $user = $user ?? Auth::user();

        if ($amount < -1)
        {
            throw new IllegalArgumentException('Die gewählte Anzahl an Produkten ist nicht verfügbar.');
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
            ->first()
            ->pivot->count;
    }

    private static function getProductInShoppingCartQuery(Product $product, Collection $attributes, User $user = null): BelongsToMany
    {
        $user = $user ?? Auth::user();

        $shopping_cart = $user->shopping_cart();

        foreach (AttributeType::cases() as $type) {
            $shopping_cart = $shopping_cart
                ->wherePivot('product_' . strtolower($type->name) . '_attribute_id', $attributes->get($type->value));
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
            throw new InvalidAttributeException('Die gewählten Attribute sind nicht verfügbar.');
        }

        $newAttributes = ['count' => $newAmount];

        foreach (AttributeType::cases() as $type) {
            if ( ! $attributes->has($type->value)) {
                continue;
            }

            $newAttributes['product_' . strtolower($type->name) . '_attribute_id'] = $attributes->get($type->value);
        }

        $user->shopping_cart()
            ->attach($product, $newAttributes);
    }
}
