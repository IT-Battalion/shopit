<?php

use App\Exceptions\ProductNotInShoppingCartException;
use App\Models\Admin;
use App\Models\CouponCode;
use App\Models\Icon;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use DASPRiD\Enum\Exception\IllegalArgumentException;

beforeEach(function () {
    $icon = Icon::factory()->create();
    Admin::factory()->create();
    ProductCategory::factory()->create(['name' => 'Test', 'icon_id' => $icon->id]);
    CouponCode::factory()->create();
});

function generateShoppingCartCoupon(User $user) {
    $coupon = CouponCode::factory()->create(['discount' => 0.20]);
    $user->shopping_cart_coupon_id = $coupon->id;
}

// =============================
// Add products
// =============================

test('add product to the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $amount = 2;

    $this->actingAs($user);

    $product = Product::factory()->create(['name' => 'TestProduct']);
    $service->addProduct($product, $amount);

    $this->assertTrue($service->hasProductInShoppingCart($product, $amount));
});

test('add product which already exists to the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);
    $user = User::factory()->create();
    $amount = 2;
    $product = Product::factory()->state(['name' => 'TestProduct'])->create();

    $this->actingAs($user);

    $service->addProduct($product, $amount);
    $service->addProduct($product, $amount);

    expect($service->hasProductInShoppingCart($product, $amount * 2))->toBeTrue();
});

test('add 0 times a product to the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->state(['name' => 'TestProduct'])->create();

    $service->addProduct($product, 0);

    expect($service->hasProductInShoppingCart($product))->toBeFalse();
});

test('add an invalid amount of a product to the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->state(['name' => 'TestProduct'])->create();

    $service->addProduct($product, -10);
})->throws(IllegalArgumentException::class);

// =============================
// Remove products
// =============================

test('remove a product from the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = saturateShoppingCart($user)[0];

    $service->removeProduct($product);

    expect($service->hasProductInShoppingCart($product))->toBeFalse();
});

test('remove a specific number of items from the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = saturateShoppingCart($user)[0];

    $service->removeProduct($product, 1);

    expect($service->hasProductInShoppingCart($product, 1))->toBeTrue();
});

test('remove all items from the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = saturateShoppingCart($user)[0];

    $service->removeProduct($product, 2);

    expect($service->hasProductInShoppingCart($product))->toBeFalse();
});

test('remove no items from the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = saturateShoppingCart($user)[0];

    $service->removeProduct($product, 0);

    expect($service->hasProductInShoppingCart($product, 2))->toBeTrue();
});

test('remove an invalid number of items from the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = saturateShoppingCart($user)[0];

    $service->removeProduct($product, -10);
})->throws(IllegalArgumentException::class);

test('remove a product from the shopping cart that isn\'t even in the shoppping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();

    $service->removeProduct($product, -10);
})->throws(ProductNotInShoppingCartException::class);

// =============================
// Set product amount
// =============================

test('set the amount of a product to an invalid number', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();

    $service->setProductAmount($product, -20);
})->throws(IllegalArgumentException::class);

test('set the amount of an product that isn\'t in the shopping cart ', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();

    $service->setProductAmount($product, 2);

    expect($service->hasProductInShoppingCart($product, 2))->toBeTrue();
});

test('set the amount of an product that isn\'t in the shopping cart to 0', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();

    $service->setProductAmount($product, 0);

    expect($service->hasProductInShoppingCart($product))->toBeFalse();
});

test('set the amount of an product that is in the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $service->setProductAmount($product, 4);

    expect($service->hasProductInShoppingCart($product, 2))->toBeFalse()
    ->and($service->hasProductInShoppingCart($product, 4))->toBeTrue();
});

test('set the amount of an product that is in the shopping cart to 0', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $service->setProductAmount($product, 0);

    expect($service->hasProductInShoppingCart($product, 2))->toBeFalse()
        ->and($service->hasProductInShoppingCart($product))->toBeFalse();
});

// =============================
// Without taxes
// =============================


test('get total price without taxes and without missing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);
    $user = User::factory()->create();

    $this->actingAs($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(false, false);

    $realPrice = 20 * 2 * 2.0;
    expect($price)->toBe($realPrice);
});

test('get total price without taxes and without existing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(false, false);

    $realPrice = 20 * 2 * 2.0;
    expect($price)->toBe($realPrice);
});

test('get total price without taxes and with missing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(false, true);

    $realPrice = 20 * 2 * 2.0;
    expect($price)->toBe($realPrice);
});

test('get total price without taxes and with existing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(false, true);

    $realPrice = 20 * 0.8 * 2 * 2;
    expect($price)->toBe($realPrice);
});

// =============================
// With taxes
// =============================

test('get total price with taxes and without missing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(true, false);

    $realPrice = 20 * 1.2 * 2 * 2;
    expect($price)->toBe($realPrice);
});

test('get total price with taxes and without existing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(true, false);

    $realPrice = 20 * 1.2 * 2 * 2;
    expect($price)->toBe($realPrice);
});

test('get total price with taxes and with missing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(true, true);

    $realPrice = 20 * 1.2 * 2 * 2;
    expect($price)->toBe($realPrice);
});

test('get total price with taxes and with existing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $price = $service->calculatePrice(true, true);

    $realPrice = 20 * 0.8 * 1.2 * 2 * 2; // Nettopreis * Rabatt * USt * Anzahl des Produkts * Anzahl der Produkte

    expect($price)->toBe($realPrice);
});

// =============================
// Calculate tax
// =============================

test('get the tax without coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $expectedTax = 20 * 0.2 * 2 * 2;

    $tax = $service->calculateTax();

    expect($tax)->tobe($expectedTax);
});

test('get the tax with coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $expectedTax = 20 * 0.8 * 0.2 * 2 * 2;

    $tax = $service->calculateTax();

    expect($tax)->tobe($expectedTax);
});

// =============================
// Calculate discount
// =============================

test('get the discount without coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    saturateShoppingCart($user);

    $expectedDiscount = 0.0;

    $discount = $service->calculateDiscount();

    expect($discount)->tobe($expectedDiscount);
});

test('get the discount with coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    generateShoppingCartCoupon($user);

    saturateShoppingCart($user);

    $expectedDiscount = 20 * 0.2 * 2 * 2;

    $discount = $service->calculateDiscount();

    expect($discount)->toBe($expectedDiscount);
});

// =============================
// Calculate product price
// Without tax
// =============================

test('get product price without taxes and without missing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create(['price' => 20.0, 'tax' => '0.2']);
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $expectedPrice = 20 * 2.0;

    $price = $service->calculatePriceOfProduct($product, false, false);

    expect($price)->toBe($expectedPrice);
});

test('get product price without taxes and without existing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create(['price' => 20.0, 'tax' => '0.2']);
    $user->shopping_cart()->attach($product, ['count' => 2]);

    generateShoppingCartCoupon($user);

    $expectedPrice = 20 * 2.0;

    $price = $service->calculatePriceOfProduct($product, false, false);

    expect($price)->toBe($expectedPrice);
});

test('get product price without taxes and with missing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create(['price' => 20.0, 'tax' => '0.2']);
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $expectedPrice = 20 * 2.0;

    $price = $service->calculatePriceOfProduct($product, false, true);

    expect($price)->toBe($expectedPrice);
});

test('get product price without taxes and with existing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create(['price' => 20.0, 'tax' => '0.2']);
    $user->shopping_cart()->attach($product, ['count' => 2]);

    generateShoppingCartCoupon($user);

    $expectedPrice = 20 * 2 * 0.8;

    $price = $service->calculatePriceOfProduct($product, false, true);

    expect($price)->toBe($expectedPrice);
});

// =============================
// Calculate product price
// With tax
// =============================

test('get product price with taxes and without missing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create(['price' => 20.0, 'tax' => '0.2']);
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $expectedPrice = 20 * 2 * 1.2;

    $price = $service->calculatePriceOfProduct($product, true, false);

    expect($price)->toBe($expectedPrice);
});

test('get product price with taxes and without existing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create(['price' => 20.0, 'tax' => '0.2']);
    $user->shopping_cart()->attach($product, ['count' => 2]);

    generateShoppingCartCoupon($user);

    $expectedPrice = 20 * 2 * 1.2;

    $price = $service->calculatePriceOfProduct($product, true, false);

    expect($price)->toBe($expectedPrice);
});

test('get product price with taxes and with missing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create(['price' => 20.0, 'tax' => '0.2']);
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $expectedPrice = 20 * 2 * 1.2;

    $price = $service->calculatePriceOfProduct($product, true, true);

    expect($price)->toBe($expectedPrice);
});

test('get product price with taxes and with existing coupon', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create(['price' => 20.0, 'tax' => '0.2']);
    $user->shopping_cart()->attach($product, ['count' => 2]);

    generateShoppingCartCoupon($user);

    $expectedPrice = 20 * 2 * 0.8 * 1.2; // price * amount * (1 - discount) * (1 + tax)

    $price = $service->calculatePriceOfProduct($product, true, true);

    expect($price)->toBe($expectedPrice);
});

// =============================
// Is Product in the shopping cart
// =============================

test('check if product is in the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $isInShoppingCart = $service->hasProductInShoppingCart($product);

    expect($isInShoppingCart)->toBeTrue();
});

test('check if a specified amount of a product is in the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $isInShoppingCart = $service->hasProductInShoppingCart($product, 2);

    expect($isInShoppingCart)->toBeTrue();
});

test('check if product isn\'t in the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();

    $isInShoppingCart = $service->hasProductInShoppingCart($product);

    expect($isInShoppingCart)->toBeFalse();
});

test('check if a specified amount of a product isn\'t in the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();
    $user->shopping_cart()->attach($product, ['count' => 2]);

    $isInShoppingCart = $service->hasProductInShoppingCart($product, 1);

    expect($isInShoppingCart)->toBeFalse();
});

test('check if 0 of a product is still in the shopping cart', function () {
    $service = $this->app->make(ShoppingCartServiceInterface::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();
    $user->shopping_cart()->attach($product, ['count' => 0]);

    $isInShoppingCart = $service->hasProductInShoppingCart($product, 1);

    expect($isInShoppingCart)->toBeFalse();
});
