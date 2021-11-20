<?php

use App\Exceptions\OrderNotOrderedException;
use App\Exceptions\OrderNotPaidException;
use App\Exceptions\OrderNotReceivedException;
use App\Exceptions\ShoppingCartEmptyException;
use App\Models\Admin;
use App\Models\OrderProduct;
use App\Models\OrderProductAttribute;
use App\Models\OrderProductImage;
use App\Models\User;
use App\Services\Orders\OrderServiceInterface;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    User::factory()->state(['isAdmin' => true])->create();
});

test('create order with 0 products in shopping cart', function () {
    actingAs(Admin::all()->random());
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    $service->createOrder($user);
})->throws(ShoppingCartEmptyException::class);

test('create order with products in shopping cart', function () {
    actingAs(Admin::all()->random());
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    $products = saturateShoppingCart($user)->all();

    $order = $service->createOrder($user);
    expect(isset($order))->toBeTrue();
    foreach ($products as $product) {
        $order_product = OrderProduct::whereName($product->name)->where('order_id', '=', $order->id);
        expect($order_product->exists())->toBeTrue();
        foreach ($product->images() as $image) {
            $order_product_image = OrderProductImage::whereOrderProductId($product->id)
                ->where($order_product->id)->where('path', '=', $image->path);
            expect($order_product_image->exists())->toBeTrue();
            if ($product->thumbnail === $image->id) {
                expect($order_product->thumbnail === $order_product_image->id)->toBeTrue();
            }
        }
        foreach ($product->attributes() as $attribute) {
            $order_product_attribute = OrderProductAttribute::whereOrderProductId($order_product->id)->where('values_chosen', '=', $attribute->values_chosen);
            expect($order_product_attribute->exists())->toBeTrue();
        }
    }
    expect($user->shopping_cart()->count() === 0)->toBeTrue();
});

test('mark order as paid', function () {
    $admin = Admin::all()->random();
    actingAs($admin);
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    saturateShoppingCart($user);
    $order = $service->createOrder($user);
    $order = $service->markOrderAsPaid($order);
    expect(isset($order->paid_at))->toBeTrue();
    expect($order->transaction_confirmed_by)->toBe($admin->id);
});

test('mark order as ordered', function () {
    $admin = Admin::all()->random();
    actingAs($admin);
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    saturateShoppingCart($user);
    $order = $service->createOrder($user);
    $order = $service->markOrderAsPaid($order);
    $order = $service->markOrderAsOrdered($order);
    expect(isset($order->products_ordered_at))->toBeTrue();
    expect($order->products_ordered_by)->toBe($admin->id);
});

test('mark order as received', function () {
    $admin = Admin::all()->random();
    actingAs($admin);
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    saturateShoppingCart($user);
    $order = $service->createOrder($user);
    $order = $service->markOrderAsPaid($order);
    $order = $service->markOrderAsOrdered($order);
    $order = $service->markOrderAsReceived($order);
    expect(isset($order->received_at))->toBeTrue();
    expect($order->received_by)->toBe($admin->id);
});

test('mark order as delivered', function () {
    $admin = Admin::all()->random();
    actingAs($admin);
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    saturateShoppingCart($user);
    $order = $service->createOrder($user);
    $order = $service->markOrderAsPaid($order);
    $order = $service->markOrderAsOrdered($order);
    $order = $service->markOrderAsReceived($order);
    $order = $service->markOrderAsDelivered($order);
    expect(isset($order->handed_over_at))->toBeTrue();
    expect($order->handed_over_by)->toBe($admin->id);
});

test('mark order as ordered which has not been paid yet', function () {
    actingAs(Admin::all()->random());
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    saturateShoppingCart($user);
    $order = $service->createOrder($user);
    $service->markOrderAsOrdered($order);
})->throws(OrderNotPaidException::class);

test('mark order as received which has not been ordered yet', function () {
    actingAs(Admin::all()->random());
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    saturateShoppingCart($user);
    $order = $service->createOrder($user);
    $order = $service->markOrderAsPaid($order);
    $service->markOrderAsReceived($order);
})->throws(OrderNotOrderedException::class);

test('mark order as delivered which has not been received yet', function () {
    actingAs(Admin::all()->random());
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    saturateShoppingCart($user);
    $order = $service->createOrder($user);
    $order = $service->markOrderAsPaid($order);
    $order = $service->markOrderAsOrdered($order);
    $service->markOrderAsDelivered($order);
})->throws(OrderNotReceivedException::class);
