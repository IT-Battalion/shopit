<?php

use App\Exceptions\IllegalArgumentException;
use App\Models\Admin;
use App\Models\CouponCode;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductClothingAttribute;
use App\Models\ProductColorAttribute;
use App\Models\ProductDimensionAttribute;
use App\Models\ProductVolumeAttribute;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use App\Types\AttributeType;
use App\Types\Money;

beforeEach(function () {
    Admin::factory()->create();
    ProductCategory::factory()->create(['name' => 'Test']);
    CouponCode::factory()->create();
});

function generateShoppingCartCoupon(User $user) {
    /** @var CouponCode $coupon */
    $coupon = CouponCode::factory()->create(['discount' => 0.20]);
    $user->shopping_cart_coupon_id = $coupon->id;
}

// =============================
// Add products
// =============================

test('add product with no attributes to shopping cart', function () {
    /** @var User $user */
    $user = User::factory()->create();
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['name' => 'TestProduct']);
    $newAmount = $service->addProduct($product, collect([]));

    expect($newAmount)->toBe(1);
    expect($service->hasProductInShoppingCart($product, collect([])))->toBeTrue();
    expect($service->getAmountOfProduct($product, collect([])))->toBe(1);
    expect($user->shopping_cart->count())->toBe(1);
});

test('add two products with no attributes to shopping cart', function () {
    /** @var User $user */
    $user = User::factory()->create();
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['name' => 'TestProduct']);
    $service->addProduct($product, collect([]));
    $newAmount = $service->addProduct($product, collect([]), amount: 2);

    expect($newAmount)->toBe(3);
    expect($service->hasProductInShoppingCart($product, collect([])))->toBeTrue();
    expect($service->getAmountOfProduct($product, collect([])))->toBe(3);
    expect($user->shopping_cart->count())->toBe(1);
});

test('add product with attributes to shopping cart', function () {
    /** @var User $user */
    $user = User::factory()->create();
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();
    /** @var ProductDimensionAttribute $dimensionAttribute */
    $dimensionAttribute = ProductDimensionAttribute::factory()->create();
    /** @var ProductVolumeAttribute $volumeAttribute */
    $volumeAttribute = ProductVolumeAttribute::factory()->create();
    /** @var ProductColorAttribute $colorAttribute */
    $colorAttribute = ProductColorAttribute::factory()->create();

    $attributes = collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
        AttributeType::DIMENSION->value => $dimensionAttribute->id,
        AttributeType::VOLUME->value => $volumeAttribute->id,
        AttributeType::COLOR->value => $colorAttribute->id,
    ]);

    /** @var Product $product */
    $product = Product::factory()->create(['name' => 'TestProduct']);

    $product->productClothingAttributes()->attach($clothingAttribute);
    $product->productDimensionAttributes()->attach($dimensionAttribute);
    $product->productVolumeAttributes()->attach($volumeAttribute);
    $product->productColorAttributes()->attach($colorAttribute);

    $newAmount = $service->addProduct($product, $attributes);

    expect($newAmount)->toBe(1);
    expect($service->hasProductInShoppingCart($product, $attributes))->toBeTrue();
    expect($user->shopping_cart->count())->toBe(1);
});

test('add two products with attributes to shopping cart', function () {
    /** @var User $user */
    $user = User::factory()->create();
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();
    /** @var ProductDimensionAttribute $dimensionAttribute */
    $dimensionAttribute = ProductDimensionAttribute::factory()->create();
    /** @var ProductVolumeAttribute $volumeAttribute */
    $volumeAttribute = ProductVolumeAttribute::factory()->create();
    /** @var ProductColorAttribute $colorAttribute */
    $colorAttribute = ProductColorAttribute::factory()->create();

    $attributes = collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
        AttributeType::DIMENSION->value => $dimensionAttribute->id,
        AttributeType::VOLUME->value => $volumeAttribute->id,
        AttributeType::COLOR->value => $colorAttribute->id,
    ]);

    /** @var Product $product */
    $product = Product::factory()->create(['name' => 'TestProduct']);

    $product->productClothingAttributes()->attach($clothingAttribute);
    $product->productDimensionAttributes()->attach($dimensionAttribute);
    $product->productVolumeAttributes()->attach($volumeAttribute);
    $product->productColorAttributes()->attach($colorAttribute);

    $service->addProduct($product, $attributes);
    $amount1 = $service->addProduct($product, $attributes, amount: 2);
    $amount2 = $service->addProduct($product, collect([]));

    expect($amount1)->toBe(3);
    expect($amount2)->toBe(1);

    expect($service->hasProductInShoppingCart($product, $attributes))->toBeTrue();
    expect($service->hasProductInShoppingCart($product, collect([])))->toBeTrue();

    expect($service->getAmountOfProduct($product, $attributes))->toBe(3);
    expect($service->getAmountOfProduct($product, collect([])))->toBe(1);

    expect($user->shopping_cart->count())->toBe(2);
});

test('add some products to the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $amount = 2;

    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['name' => 'TestProduct']);
    /** @var Product $product2 */
    $product2 = Product::factory()->create(['name' => 'TestProduct2']);

    $amount1 = $service->addProduct($product, collect([]), $amount);
    $amount2 = $service->addProduct($product2, collect([]), $amount);

    expect($amount1)->toBe(2);
    expect($amount2)->toBe(2);

    expect($service->hasProductInShoppingCart($product, collect([]), $amount))->toBeTrue();
    expect($service->hasProductInShoppingCart($product2, collect([]), $amount))->toBeTrue();
});

test('add a product 0 times to the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->state(['name' => 'TestProduct'])->create();

    $amount = $service->addProduct($product, collect([]), 0);

    expect($amount)->toBe(0);
    expect($service->hasProductInShoppingCart($product, collect([])))->toBeFalse();
});

test('add an invalid amount of a product to the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->state(['name' => 'TestProduct'])->create();

    $service->addProduct($product, collect([]), -10);
})->throws(IllegalArgumentException::class);

// =============================
// Remove products
// =============================

test('remove a product with no attributes from the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    $product = saturateShoppingCart($user)->first();

    $amount = $service->removeProduct($product, collect([]));

    expect($amount)->toBe(0);
    expect($service->hasProductInShoppingCart($product, collect([])))->toBeFalse();
    expect($user->shopping_cart->count())->toBe(1);
});

test('remove a product with attributes from the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();
    /** @var ProductDimensionAttribute $dimensionAttribute */
    $dimensionAttribute = ProductDimensionAttribute::factory()->create();
    /** @var ProductVolumeAttribute $volumeAttribute */
    $volumeAttribute = ProductVolumeAttribute::factory()->create();
    /** @var ProductColorAttribute $colorAttribute */
    $colorAttribute = ProductColorAttribute::factory()->create();

    /** @var Product $product */
    $product = Product::factory()->create();

    $product->productClothingAttributes()->attach($clothingAttribute);
    $product->productDimensionAttributes()->attach($dimensionAttribute);
    $product->productVolumeAttributes()->attach($volumeAttribute);
    $product->productColorAttributes()->attach($colorAttribute);

    $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
        AttributeType::DIMENSION->value => $dimensionAttribute->id,
        AttributeType::VOLUME->value => $volumeAttribute->id,
        AttributeType::COLOR->value => $colorAttribute->id,
    ]), 2);
    $amount1 = $service->addProduct($product, collect([]));

    $amount2 = $service->removeProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
        AttributeType::DIMENSION->value => $dimensionAttribute->id,
        AttributeType::VOLUME->value => $volumeAttribute->id,
        AttributeType::COLOR->value => $colorAttribute->id,
    ]));

    expect($amount1)->toBe(1);
    expect($amount2)->toBe(0);

    expect($service->hasProductInShoppingCart($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
        AttributeType::DIMENSION->value => $dimensionAttribute->id,
        AttributeType::VOLUME->value => $volumeAttribute->id,
        AttributeType::COLOR->value => $colorAttribute->id,
    ])))->toBeFalse();
    expect($service->hasProductInShoppingCart($product, collect([])))->toBeTrue();
    expect($service->getAmountOfProduct($product, collect([])))->toBe(1);
    expect($user->shopping_cart->count())->toBe(1);
});

test('remove a specific number of items from the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create();

    $amount1 = $service->addProduct($product, collect([]), 2);

    $amount2 = $service->removeProduct($product, collect([]), 1);

    expect($amount1)->toBe(2);
    expect($amount2)->toBe(1);

    expect($service->hasProductInShoppingCart($product, collect([]), 1))->toBeTrue();
});

test('remove all items from the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();

    $product = saturateShoppingCart($user)->first();
    $product->productClothingAttributes()->attach($clothingAttribute);

    $amount1 = $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]));

    $amount2 = $service->removeProduct($product, collect([]), 2);

    expect($amount1)->toBe(1);
    expect($amount2)->toBe(0);

    expect($service->hasProductInShoppingCart($product, collect([])))->toBeFalse();
    expect($service->hasProductInShoppingCart($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ])))->toBetrue();
});

test('remove no items from the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();

    $product = saturateShoppingCart($user)->first();
    $product->productClothingAttributes()->attach($clothingAttribute);

    $amount1 = $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]));

    $amount2 = $service->removeProduct($product, collect([]), 0);

    expect($amount1)->toBe(1);
    expect($amount2)->toBe(0);

    expect($service->hasProductInShoppingCart($product, collect([]), 2))->toBeTrue();
    expect($service->hasProductInShoppingCart($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ])))->toBeTrue();
});

test('remove an invalid number of items from the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    $product = saturateShoppingCart($user)->first();

    $service->removeProduct($product, collect([]), -10);
})->throws(IllegalArgumentException::class);

test('remove a product from the shopping cart that isn\'t even in the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create();

    $service->removeProduct($product, collect([]), -10);

    expect(true)->toBeTrue();
});

// =============================
// Set product amount
// =============================

test('set the amount of a product to an invalid number', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create();

    $service->setProductAmount($product, collect([]), -20);
})->throws(IllegalArgumentException::class);

test('set the amount of an product that isn\'t in the shopping cart ', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create();

    $service->setProductAmount($product, collect([]), 2);

    expect($service->hasProductInShoppingCart($product, collect([]), 2))->toBeTrue();
});

test('set the amount of an product that isn\'t in the shopping cart to 0', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();

    /** @var Product $product */
    $product = Product::factory()->create();
    $product->productClothingAttributes()->attach($clothingAttribute);

    $amount = $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]));
    $service->setProductAmount($product, collect([]), 0);

    expect($amount)->toBe(1);

    expect($service->hasProductInShoppingCart($product, collect([])))->toBeFalse();
    expect($service->hasProductInShoppingCart($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ])))->toBeTrue();
});

test('set the amount of an product that is in the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();

    /** @var Product $product */
    $product = Product::factory()->create();
    $product->productClothingAttributes()->attach($clothingAttribute);

    $amount1 = $service->addProduct($product, collect([]));
    $amount2 = $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]), 2);

    $service->setProductAmount($product, collect([]), 4);

    expect($amount1)->toBe(1);
    expect($amount2)->toBe(2);

    expect($service->hasProductInShoppingCart($product, collect([]), 2))->toBeFalse()
    ->and($service->hasProductInShoppingCart($product, collect([]), 4))->toBeTrue();
    expect($service->hasProductInShoppingCart($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]), 2))->toBeTrue();
});

test('set the amount of an product that is in the shopping cart to 0', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();

    /** @var Product $product */
    $product = Product::factory()->create();
    $product->productClothingAttributes()->attach($clothingAttribute);

    $amount1 = $service->addProduct($product, collect([]), 2);
    $amount2 = $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]), 2);

    $service->setProductAmount($product, collect([]), 0);

    expect($amount1)->toBe(2);
    expect($amount2)->toBe(2);

    expect($service->hasProductInShoppingCart($product, collect([]), 2))->toBeFalse()
        ->and($service->hasProductInShoppingCart($product, collect([])))->toBeFalse();
    expect($service->hasProductInShoppingCart($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]), 2))->toBeTrue();
});

// =============================
// Without taxes
// =============================


test('get total price without taxes and without missing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(false, false);

    $realPrice = new Money(20 * 2 * 2.0);
    expect($price)->toEqual($realPrice);
});

test('get total price without taxes and without existing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(false, false);

    $realPrice = new Money(20 * 2 * 2.0);
    expect($price)->toEqual($realPrice);
});

test('get total price without taxes and with missing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(false, true);

    $realPrice = new Money(20 * 2 * 2.0);
    expect($price)->toEqual($realPrice);
});

test('get total price without taxes and with existing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(false, true);

    $realPrice = new Money(20 * 0.8 * 2 * 2);
    expect($price)->toEqual($realPrice);
});

// =============================
// With taxes
// =============================

test('get total price with taxes and without missing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(true, false);

    $realPrice = new Money(20 * 1.2 * 2 * 2);
    expect($price)->toEqual($realPrice);
});

test('get total price with taxes and without existing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(true, false);

    $realPrice = new Money(20 * 1.2 * 2 * 2);
    expect($price)->toEqual($realPrice);
});

test('get total price with taxes and with missing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(true, true);

    $realPrice = new Money(20 * 1.2 * 2 * 2);
    expect($price)->toEqual($realPrice);
});

test('get total price with taxes and with existing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(true, true);

    $realPrice = new Money(20 * 0.8 * 1.2 * 2 * 2); // Nettopreis * Rabatt * USt * Anzahl des Produkts * Anzahl der Produkte

    expect($price)->toEqual($realPrice);
});

// =============================
// Calculate tax
// =============================

test('get the tax without coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $expectedTax = new Money(20 * 0.2 * 2 * 2);

    $tax = $service->calculateTax();

    expect($tax)->toEqual($expectedTax);
});

test('get the tax with coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $expectedTax = new Money(20 * 0.8 * 0.2 * 2 * 2);

    $tax = $service->calculateTax();

    expect($tax)->toEqual($expectedTax);
});

// =============================
// Calculate discount
// =============================

test('get the discount without coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $expectedDiscount = new Money(0);

    $discount = $service->calculateDiscount();

    expect($discount)->toEqual($expectedDiscount);
});

test('get the discount with coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $expectedDiscount = new Money(20 * 0.2 * 2 * 2);

    $discount = $service->calculateDiscount();

    expect($discount)->toEqual($expectedDiscount);
});

// =============================
// Calculate product price
// Without tax
// =============================

test('get product price without taxes and without missing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['price' => new Money(20), 'tax' => '0.2']);
    $service->addProduct($product, collect([]), 2);

    $expectedPrice = new Money(20 * 2.0);

    $price = $service->calculatePriceOfProduct($product, collect([]), false, false);

    expect($price)->toEqual($expectedPrice);
});

test('get product price without taxes and without existing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['price' => new Money(20), 'tax' => '0.2']);
    $service->addProduct($product, collect([]), 2);

    generateShoppingCartCoupon($user);

    $expectedPrice = new Money(20 * 2.0);

    $price = $service->calculatePriceOfProduct($product, collect([]), false, false);

    expect($price)->toEqual($expectedPrice);
});

test('get product price without taxes and with missing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['price' => new Money(20), 'tax' => '0.2']);
    $service->addProduct($product, collect([]), 2);

    $expectedPrice = new Money(20 * 2.0);

    $price = $service->calculatePriceOfProduct($product, collect([]), false, true);

    expect($price)->toEqual($expectedPrice);
});

test('get product price without taxes and with existing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['price' => new Money(20), 'tax' => '0.2']);
    $service->addProduct($product, collect([]), 2);

    generateShoppingCartCoupon($user);

    $expectedPrice = new Money(20 * 2 * 0.8);

    $price = $service->calculatePriceOfProduct($product, collect([]), false, true);

    expect($price)->toEqual($expectedPrice);
});

// =============================
// Calculate product price
// With tax
// =============================

test('get product price with taxes and without missing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['price' => new Money(20), 'tax' => '0.2']);
    $service->addProduct($product, collect([]), 2);

    $expectedPrice = new Money(20 * 2 * 1.2);

    $price = $service->calculatePriceOfProduct($product, collect([]), true, false);

    expect($price)->toEqual($expectedPrice);
});

test('get product price with taxes and without existing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['price' => new Money(20), 'tax' => '0.2']);
    $service->addProduct($product, collect([]), 2);

    generateShoppingCartCoupon($user);

    $expectedPrice = new Money(20 * 2 * 1.2);

    $price = $service->calculatePriceOfProduct($product, collect([]), true, false);

    expect($price)->toEqual($expectedPrice);
});

test('get product price with taxes and with missing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['price' => new Money(20), 'tax' => '0.2']);
    $service->addProduct($product, collect([]), 2);

    $expectedPrice = new Money(20 * 2 * 1.2);

    $price = $service->calculatePriceOfProduct($product, collect([]), true, true);

    expect($price)->toEqual($expectedPrice);
});

test('get product price with taxes and with existing coupon', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create(['price' => new Money(20), 'tax' => '0.2']);
    $service->addProduct($product, collect([]), 2);

    generateShoppingCartCoupon($user);

    $expectedPrice = new Money(20 * 2 * 0.8 * 1.2); // price * amount * (1 - discount) * (1 + tax)

    $price = $service->calculatePriceOfProduct($product, collect([]), true, true);

    expect($price)->toEqual($expectedPrice);
});

// =============================
// Is Product in the shopping cart
// =============================

test('check if product is in a shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create();
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $isInShoppingCart = $service->hasProductInShoppingCart($product, collect([]));

    expect($isInShoppingCart)->toBeTrue();
});

test('check if product is not in the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();

    /** @var Product $product */
    $product = Product::factory()->create();
    $product->productClothingAttributes()->attach($clothingAttribute);

    $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]), 3);

    $isInShoppingCart = $service->hasProductInShoppingCart($product, collect([]));

    expect($isInShoppingCart)->toBeFalse();
});

test('check if a specified amount of a product is in the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();

    /** @var Product $product */
    $product = Product::factory()->create();
    $product->productClothingAttributes()->attach($clothingAttribute);

    $service->addProduct($product, collect([]), 2);
    $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]), 3);

    $isInShoppingCart = $service->hasProductInShoppingCart($product, collect([]), 2);

    expect($isInShoppingCart)->toBeTrue();
});

test('check if a specified amount of a product isn\'t in the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var ProductClothingAttribute $clothingAttribute */
    $clothingAttribute = ProductClothingAttribute::factory()->create();

    /** @var Product $product */
    $product = Product::factory()->create();
    $product->productClothingAttributes()->attach($clothingAttribute);

    $service->addProduct($product, collect([]), 2);
    $service->addProduct($product, collect([
        AttributeType::CLOTHING->value => $clothingAttribute->id,
    ]), 1);

    $isInShoppingCart = $service->hasProductInShoppingCart($product, collect([]), 1);

    expect($isInShoppingCart)->toBeFalse();
});

test('check if 0 of a product is still in the shopping cart', function () {
    /** @var ShoppingCartServiceInterface $service */
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Product $product */
    $product = Product::factory()->create();
    $user->shopping_cart()->attach($product, ['count' => 0]);

    $isInShoppingCart = $service->hasProductInShoppingCart($product, collect([]), 1);

    expect($isInShoppingCart)->toBeFalse();
});

test('total shopping cart price', function () {
    /** @var ShoppingCartServiceInterface $shoppingCart */
    $shoppingCart = $this->app->make(ShoppingCartServiceInterface::class);

    /** @var User $user */
    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $subtotal = $shoppingCart->calculatePrice(false, false);
    $totalDiscount = $shoppingCart->calculateDiscount();
    $totalTax = $shoppingCart->calculateTax();
    $total = $shoppingCart->calculatePrice(true, true);

    $realPrice = [
        'subtotal' => $subtotal,
        'discount' => $totalDiscount,
        'tax' => $totalTax,
        'total' => $total,
    ];

    $grouped = $shoppingCart->calculateShoppingCartPrice();

    expect($grouped)->toEqual($realPrice);
});
