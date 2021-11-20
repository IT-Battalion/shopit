<?php

use App\Exceptions\OrderNotOrderedException;
use App\Exceptions\OrderNotPaidException;
use App\Exceptions\OrderNotReceivedException;
use App\Exceptions\ShoppingCartEmptyException;
use App\Models\Admin;
use App\Models\CouponCode;
use App\Models\Icon;
use App\Models\OrderProduct;
use App\Models\OrderProductAttribute;
use App\Models\OrderProductImage;
use App\Models\ProductCategory;
use App\Models\User;
use App\Services\Orders\OrderServiceInterface;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $icon = Icon::factory()->create();
    Admin::factory()->create();
    ProductCategory::factory()->create(['name' => 'Test', 'icon_id' => $icon->id]);
    CouponCode::factory()->create();
});

test('create order with 0 products in shopping cart', function () {
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    actingAs($user);

    $service->createOrder($user);
})->throws(ShoppingCartEmptyException::class);

test('create order with products in shopping cart', function () {
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    $products = saturateShoppingCart($user)->all();
    actingAs($user);

    $order = $service->createOrder($user);
    expect(isset($order))->toBeTrue();
    $this->assertModelExists($order);

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
        foreach ($product->productAttributes as $attribute) {
            $order_product_attribute = OrderProductAttribute::whereOrderProductId($order_product->id)->where('values_chosen', '=', $attribute->values_chosen);
            expect($order_product_attribute->exists())->toBeTrue();
        }
    }
    expect($user->shopping_cart()->count() === 0)->toBeTrue();
});

test('mark order as paid', function () {
    $admin = Admin::factory()->create();
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $order = $service->markOrderAsPaid($order);

    expect(isset($order->paid_at))->toBeTrue();
    expect($order->transaction_confirmed_by->id)->toBe($admin->id);
});

test('mark order as ordered', function () {
    $admin = Admin::factory()->create();
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $order = $service->markOrderAsPaid($order);
    $order = $service->markOrderAsOrdered($order);

    expect($order->isOrdered())->toBeTrue();
    expect($order->products_ordered_by->id)->toBe($admin->id);
});

test('mark order as received', function () {
    $admin = Admin::factory()->create();
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $order = $service->markOrderAsPaid($order);
    $order = $service->markOrderAsOrdered($order);
    $order = $service->markOrderAsReceived($order);

    expect($order->isReceived())->toBeTrue();
    expect($order->products_received_by->id)->toBe($admin->id);
});

test('mark order as delivered', function () {
    $admin = Admin::factory()->create();
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $order = $service->markOrderAsPaid($order);
    $order = $service->markOrderAsOrdered($order);
    $order = $service->markOrderAsReceived($order);
    $order = $service->markOrderAsDelivered($order);

    expect($order->isHandedOver())->toBeTrue();
    expect($order->handed_over_by->id)->toBe($admin->id);
});

test('mark order as ordered which has not been paid yet', function () {
    $admin = Admin::factory()->create();
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $service->markOrderAsOrdered($order);
})->throws(OrderNotPaidException::class);

test('mark order as received which has not been ordered yet', function () {
    $admin = Admin::factory()->create();
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $order = $service->markOrderAsPaid($order);
    $service->markOrderAsReceived($order);
})->throws(OrderNotOrderedException::class);

test('mark order as delivered which has not been received yet', function () {
    $admin = Admin::factory()->create();
    $service = $this->app->make(OrderServiceInterface::class);
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $order = $service->markOrderAsPaid($order);
    $order = $service->markOrderAsOrdered($order);
    $service->markOrderAsDelivered($order);
})->throws(OrderNotReceivedException::class);
