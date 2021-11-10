<?php

use App\Exceptions\ProductNotInShoppingCartException;
use App\Models\CouponCode;
use App\Models\Product;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartService;

test('add product to shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
    $product = Product::all()->first();
    $service->addProduct($product, 2);
    expect($service->hasShoppingCartProduct($product, 2))->toBeTrue()
        ->and($service->hasShoppingCartProduct($product, 10))->toBeFalse();
});

test('add product which is already existing to shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
    $product = Product::all()->first();
    $service->addProduct($product);
    expect($service->hasShoppingCartProduct($product, 3))->toBeTrue();
});

test('get total price without taxes', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
    $price = $service->calculatePrice(false);
    $product = Product::all()->first();
    $amount = $service->getAmountOfProduct($product);
    $realPrice = $amount * $product->price;
    expect($price)->toBe($realPrice);
});

test('get total price with taxes', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
    $price = $service->calculatePrice(true);
    $product = Product::all()->first();
    $amount = $service->getAmountOfProduct($product);
    $tax = $product->tax;
    $realPrice = (($amount * $product->price) / 100) * (100 + $tax);
    expect($price)->toBe($realPrice);
});

test('get total price with coupon', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
    $coupon = CouponCode::all()->random();
    $price = $service->calculatePrice(true, $coupon);
    $product = Product::all()->first();
    $amount = $service->getAmountOfProduct($product);
    $tax = $product->tax;
    $couponPrice = $amount * $product->price;
    $realPrice = ((($couponPrice / 100) * (100 - $coupon->discount)) / 100) * (100 + $tax);
    expect($price)->toBe($realPrice);
});

test('remove 1 (amount) from shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
    $product = Product::all()->first();
    $service->removeProduct($product);
    expect($service->hasShoppingCartProduct($product, 3))->toBeFalse()
        ->and($service->hasShoppingCartProduct($product, 2))->toBeTrue();
});

test('remove product from shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
    $product = Product::all()->first();
    $service->removeProduct($product, -1);
    expect($service->hasShoppingCartProduct($product))->toBeFalse();
});

test('remove none existing product from shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
    $product = Product::all()->first();
    //preperation to be sure the product is gone :)
    if (!$service->hasShoppingCartProduct($product)) $service->removeProduct($product, -1);
    //end preperation
    $service->removeProduct($product);
})->throws(ProductNotInShoppingCartException::class);
