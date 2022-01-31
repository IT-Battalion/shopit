<?php

use App\Exceptions\ShoppingCartEmptyException;
use App\Models\Admin;
use App\Models\CouponCode;
use App\Models\OrderProduct;
use App\Models\OrderProductImage;
use App\Models\ProductCategory;
use App\Models\User;
use App\Services\Orders\OrderServiceInterface;
use App\Types\OrderStatus;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    Admin::factory()->create();
    ProductCategory::factory()->create(['name' => 'Test']);
    CouponCode::factory()->create();
});

test('create order with 0 products in shopping cart', function () {
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    $service->createOrder($user);
})->throws(ShoppingCartEmptyException::class);

test('create order with products in shopping cart', function () {
    /** @var OrderServiceInterface $service */
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
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
        expect($product->productAttributes->flatten()->all())->toHaveLength(0);
    }
    expect($user->shopping_cart()->count())->toBe(0);

    expect($order->isPaid())->toBeFalse();
    expect($order->isOrdered())->toBeFalse();
    expect($order->isReceived())->toBeFalse();
    expect($order->isHandedOver())->toBeFalse();
    expect($order->transaction_confirmed_by)->toBeNull();
    expect($order->products_ordered_by)->toBeNull();
    expect($order->products_received_by)->toBeNull();
    expect($order->handed_over_by)->toBeNull();
    expect($order->paid_at)->toBeNull();
    expect($order->products_ordered_at)->toBeNull();
    expect($order->products_received_by)->toBeNull();
    expect($order->handed_over_at)->toBeNull();

    expect($order->status)->toBe(OrderStatus::CREATED);
});

test('increment order status of new order', function () {
    /** @var Admin $admin */
    $admin = Admin::factory()->create();
    /** @var OrderServiceInterface $service */
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $service->incrementOrderStatus($order);

    expect($order->isPaid())->toBeTrue();
    expect($order->isOrdered())->toBeFalse();
    expect($order->isReceived())->toBeFalse();
    expect($order->isHandedOver())->toBeFalse();
    expect($order->transaction_confirmed_by->id)->toBe($admin->id);
    expect($order->products_ordered_by)->toBeNull();
    expect($order->products_received_by)->toBeNull();
    expect($order->handed_over_by)->toBeNull();
    expect($order->paid_at)->toBeObject();
    expect($order->products_ordered_at)->toBeNull();
    expect($order->products_received_by)->toBeNull();
    expect($order->handed_over_at)->toBeNull();
});

test('increment order status of order', function () {
    /** @var Admin $admin */
    $admin = Admin::factory()->create();
    /** @var OrderServiceInterface $service */
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);

    expect($order->isPaid())->toBeTrue();
    expect($order->isOrdered())->toBeTrue();
    expect($order->isReceived())->toBeTrue();
    expect($order->isHandedOver())->toBeFalse();
    expect($order->transaction_confirmed_by?->id)->toBe($admin->id);
    expect($order->products_ordered_by?->id)->toBe($admin->id);
    expect($order->products_received_by?->id)->toBe($admin->id);
    expect($order->handed_over_by)->toBeNull();
    expect($order->paid_at)->toBeObject();
    expect($order->products_ordered_at)->toBeObject();
    expect($order->products_received_by)->toBeObject();
    expect($order->handed_over_at)->toBeNull();

    expect($order->status)->toBe(OrderStatus::RECEIVED);
});

test('finish order status of order', function () {
    /** @var Admin $admin */
    $admin = Admin::factory()->create();
    /** @var OrderServiceInterface $service */
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);

    expect($order->isPaid())->toBeTrue();
    expect($order->isOrdered())->toBeTrue();
    expect($order->isReceived())->toBeTrue();
    expect($order->isHandedOver())->toBeTrue();
    expect($order->transaction_confirmed_by?->id)->toBe($admin->id);
    expect($order->products_ordered_by?->id)->toBe($admin->id);
    expect($order->products_received_by?->id)->toBe($admin->id);
    expect($order->handed_over_by?->id)->toBe($admin->id);
    expect($order->paid_at)->toBeObject();
    expect($order->products_ordered_at)->toBeObject();
    expect($order->products_received_by)->toBeObject();
    expect($order->handed_over_at)->toBeObject();

    expect($order->status)->toBe(OrderStatus::HANDED_OVER);
});

test('increment order status of order over maximum', function () {
    /** @var Admin $admin */
    $admin = Admin::factory()->create();
    /** @var OrderServiceInterface $service */
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
})->throws(Error::class);

test('decrement order status of new order', function () {
    /** @var Admin $admin */
    $admin = Admin::factory()->create();
    /** @var OrderServiceInterface $service */
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $service->decrementOrderStatus($order);
})->throws(Error::class);

test('decrement order status of order', function () {
    /** @var Admin $admin */
    $admin = Admin::factory()->create();
    /** @var OrderServiceInterface $service */
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->decrementOrderStatus($order);
    $service->decrementOrderStatus($order);

    expect($order->isPaid())->toBeTrue();
    expect($order->isOrdered())->toBeFalse();
    expect($order->isReceived())->toBeFalse();
    expect($order->isHandedOver())->toBeFalse();
    expect($order->transaction_confirmed_by->id)->toBe($admin->id);
    expect($order->products_ordered_by)->toBeNull();
    expect($order->products_received_by)->toBeNull();
    expect($order->handed_over_by)->toBeNull();
    expect($order->paid_at)->toBeObject();
    expect($order->products_ordered_at)->toBeNull();
    expect($order->products_received_by)->toBeNull();
    expect($order->handed_over_at)->toBeNull();

    expect($order->status)->toBe(OrderStatus::PAID);
});

test('decrement order status of order back to CREATED', function () {
    /** @var Admin $admin */
    $admin = Admin::factory()->create();
    /** @var OrderServiceInterface $service */
    $service = $this->app->make(OrderServiceInterface::class);
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    saturateShoppingCart($user);
    $order = $service->createOrder($user);

    actingAs($admin);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->incrementOrderStatus($order);
    $service->decrementOrderStatus($order);
    $service->decrementOrderStatus($order);
    $service->decrementOrderStatus($order);
    $service->decrementOrderStatus($order);

    expect($order->isPaid())->toBeFalse();
    expect($order->isOrdered())->toBeFalse();
    expect($order->isReceived())->toBeFalse();
    expect($order->isHandedOver())->toBeFalse();
    expect($order->transaction_confirmed_by)->toBeNull();
    expect($order->products_ordered_by)->toBeNull();
    expect($order->products_received_by)->toBeNull();
    expect($order->handed_over_by)->toBeNull();
    expect($order->paid_at)->toBeNull();
    expect($order->products_ordered_at)->toBeNull();
    expect($order->products_received_by)->toBeNull();
    expect($order->handed_over_at)->toBeNull();

    expect($order->status)->toBe(OrderStatus::CREATED);
});
