<?php

use App\Models\Admin;
use App\Models\CouponCode;
use App\Models\HighlightedProduct;
use App\Models\Icon;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductAttribute;
use App\Models\OrderProductCategory;
use App\Models\OrderProductImage;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\User;

beforeEach(function () {
    $icon = Icon::factory()->create();
    Admin::factory()->create();
    ProductCategory::factory()->create(['name' => 'Test', 'icon_id' => $icon->id]);
    OrderProductCategory::factory()->create(['name' => 'Test', 'icon_id' => $icon->id]);
    CouponCode::factory()->create();
});

test('admin relation to no created products', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();

    $products = $admin->products_created->all();

    expect($products)->toEqual([]);
});

test('admin relation to created products', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();

    $expectedProducts = Product::factory()->count(2)->create([
        'created_by_id' => $admin->id,
        'updated_by_id' => $admin->id,
    ])
        ->map(function (Product $product) {
            return $product->id;
        })
        ->all();

    $products = $admin->products_created
        ->map(function (Product $product) {
            return $product->id;
        })
        ->all();

    expect($products)->toEqual($expectedProducts);
});

test('admin relation to no updated products', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();
    $admin2 = Admin::factory()->create();

    Product::factory()->count(2)->create([
        'created_by_id' => $admin2->id,
        'updated_by_id' => $admin2->id,
    ]);

    $products = $admin->products_updated->all();

    expect($products)->toEqual([]);
});

test('admin relation to updated products', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();
    $admin2 = Admin::factory()->create();

    $expectedProducts = Product::factory()->count(2)->create([
        'created_by_id' => $admin2->id,
        'updated_by_id' => $admin->id,
    ])
        ->map(function (Product $product) {
            return $product->id;
        })
        ->all();

    $products = $admin->products_updated
        ->map(function (Product $product) {
            return $product->id;
        })
        ->all();

    expect($products)->toEqual($expectedProducts);
});

test('admin relation to no products in the shopping cart', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();

    $products = Product::factory()->count(2)->create();

    $products = $admin->shopping_cart->all();

    expect($products)->toEqual([]);
});

test('admin relation to products in the shopping cart', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();

    $products = Product::factory()->count(2)->create();
    $admin->shopping_cart()->attach($products, ['count' => 2]);

    $products = $admin->shopping_cart->all();

    expect($products)->toEqual($products);
});

test('admin relation to no orders', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();

    $orders = $admin->orders->all();

    expect($orders)->toEqual([]);
});

test('admin relation to orders', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();

    $expectedOrders = Order::factory()->count(2)->create([
        'customer_id' => $admin->id,
    ])
    ->map(function (Order $order) {
        return $order->id;
    });

    $orders = $admin->orders
        ->map(function (Order $order) {
            return $order->id;
        })
        ->all();

    expect($orders)->toEqual($expectedOrders->all());
});

test('user relation to no products in the shopping cart', function () {
    $user = User::factory()->create();

    $products = Product::factory()->count(2)->create();

    $products = $user->shopping_cart->all();

    expect($products)->toEqual([]);
});

test('user relation to products in the shopping cart', function () {
    $user = User::factory()->create();

    $products = Product::factory()->count(2)->create();
    $user->shopping_cart()->attach($products, ['count' => 2]);

    $products = $user->shopping_cart->all();

    expect($products)->toEqual($products);
});

test('user relation to no orders', function () {
    $user = User::factory()->create();

    $orders = $user->orders->all();

    expect($orders)->toEqual([]);
});

test('user relation to orders', function () {
    $user = User::factory()->create();

    $expectedOrders = Order::factory()->count(2)->create([
        'customer_id' => $user->id,
    ])
        ->map(function (Order $order) {
            return $order->id;
        });

    $orders = $user->orders
        ->map(function (Order $order) {
            return $order->id;
        })
        ->all();

    expect($orders)->toEqual($expectedOrders->all());
});

test('coupon relation to creator', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();
    $admin2 = Admin::factory()->create();

    $coupon = CouponCode::factory()->create([
        'created_by_id' => $admin->id,
        'updated_by_id' => $admin2->id,
    ]);

    expect($coupon->created_by->id)->toBe($admin->id);
});

test('coupon relation to updater', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();
    $admin2 = Admin::factory()->create();

    $coupon = CouponCode::factory()->create([
        'created_by_id' => $admin2->id,
        'updated_by_id' => $admin->id,
    ]);

    expect($coupon->updated_by->id)->toBe($admin->id);
});

test('Highlighted product relation to product', function () {
    $product = Product::factory()->create();

    $highlightedProduct = HighlightedProduct::factory()->create([
        'product_id' => $product->id,
    ]);

    expect($highlightedProduct->product->id)->toBe($product->id);
});

test('Order to no coupon', function () {
    $order = Order::factory()->create([
        'coupon_code_id' => null
    ]);

    expect($order->coupon_code)->toBe(null);
});

test('Order to coupon', function () {
    $coupon = CouponCode::factory()->create();
    $order = Order::factory()->create([
        'coupon_code_id' => $coupon,
    ]);

    expect($order->coupon_code->id)->toBe($coupon->id);
});

test('Order to customer', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create([
        'customer_id' => $user,
    ]);

    expect($order->customer->id)->toBe($user->id);
});

test('Order to no supply ordered admin', function () {
    $order = Order::factory()->create([
        'products_ordered_by_id' => null,
    ]);

    expect($order->products_ordered_by)->toBe(null);
});

test('Order to supply ordered admin', function () {
    $admin = Admin::factory()->create();
    $order = Order::factory()->create([
        'products_ordered_by_id' => $admin->id,
    ]);

    expect($order->products_ordered_by->id)->toBe($admin->id);
});

test('Order to no receiver admin', function () {
    $order = Order::factory()->create([
        'products_received_by_id' => null,
    ]);

    expect($order->products_received_by)->toBe(null);
});

test('Order to receiver admin', function () {
    $admin = Admin::factory()->create();
    $order = Order::factory()->create([
        'products_received_by_id' => $admin->id,
    ]);

    expect($order->products_received_by->id)->toBe($admin->id);
});

test('Order to no transaction confirming admin', function () {
    $order = Order::factory()->create([
        'transaction_confirmed_by_id' => null,
    ]);

    expect($order->transaction_confirmed_by)->toBe(null);
});

test('Order to transaction confirming admin', function () {
    $admin = Admin::factory()->create();
    $order = Order::factory()->create([
        'transaction_confirmed_by_id' => $admin->id,
    ]);

    expect($order->transaction_confirmed_by->id)->toBe($admin->id);
});

test('Order to no handed over by admin', function () {
    $order = Order::factory()->create([
        'handed_over_by_id' => null,
    ]);

    expect($order->handed_over_by)->toBe(null);
});

test('Order to handed over by admin', function () {
    $admin = Admin::factory()->create();
    $order = Order::factory()->create([
        'handed_over_by_id' => $admin->id,
    ]);

    expect($order->handed_over_by->id)->toBe($admin->id);
});

test('Order to no products', function () {
    $order = Order::factory()->create([]);

    expect($order->products->all())->toBe([]);
});

test('Order to products', function () {
    $order = Order::factory()->create([]);

    $expectedProducts = OrderProduct::factory()->count(4)->create([
        'order_id' => $order->id,
    ])
        ->map(function (OrderProduct $orderProduct) {
            return $orderProduct->id;
        });

    $products = $order->products
        ->map(function (OrderProduct $orderProduct) {
            return $orderProduct->id;
        });

    expect($products->all())->toBe($expectedProducts->all());
});

test('OrderProduct to no thumbnail', function () {
    Order::factory()->create();
    $orderProduct = OrderProduct::factory()->create();

    expect($orderProduct->thumbnail)->toBe(null);
});

test('OrderProduct to thumbnail', function () {
    Order::factory()->create();
    $orderProduct = OrderProduct::factory()->create();
    $orderProductImage = OrderProductImage::factory()->create();

    $orderProduct->thumbnail_id = $orderProductImage->id;

    expect($orderProduct->thumbnail->id)->toBe($orderProductImage->id);
});

test('OrderProduct to creator', function () {
    $admin = Admin::factory()->create();
    Order::factory()->create();
    $product = OrderProduct::factory()->create([
        'created_by_id' => $admin->id,
    ]);

    expect($product->created_by->id)->toBe($admin->id);
});

test('OrderProduct to updater', function () {
    $admin = Admin::factory()->create();
    Order::factory()->create();
    $product = OrderProduct::factory()->create([
        'updated_by_id' => $admin->id,
    ]);

    expect($product->updated_by->id)->toBe($admin->id);
});

test('OrderProduct to images', function () {
    Order::factory()->create();
    $product = OrderProduct::factory()->create();

    $expectedImages = OrderProductImage::factory()->count(4)->create([
        'order_product_id' => $product->id,
    ])
    ->map(function (OrderProductImage $image) {
        return $image->id;
    });

    $images = $product->images
        ->map(function (OrderProductImage $image) {
            return $image->id;
        });

    expect($expectedImages->all())->toBe($images->all());
});

test('OrderProduct to attributes', function () {
    Order::factory()->create();
    $product = OrderProduct::factory()->create();

    $expectedAttributes = OrderProductAttribute::factory()->count(4)->create([
        'order_product_id' => $product->id,
    ])
    ->map(function (OrderProductAttribute $attribute) {
        return $attribute->id;
    });

    $attributes = $product->productAttributes
        ->map(function (OrderProductAttribute $attribute) {
            return $attribute->id;
        });

    expect($attributes)->toEqual($expectedAttributes);
});

test('OrderProductAttribute to OrderProduct', function () {
    Order::factory()->create();
    $product = OrderProduct::factory()->create();
    $attribute = OrderProductAttribute::factory()->create([
        'order_product_id' => $product->id,
    ]);

    expect($attribute->product->id)->toEqual($product->id);
});

test('OrderProductImage to OrderProduct', function () {
    Order::factory()->create();
    $product = OrderProduct::factory()->create();
    $image = OrderProductImage::factory()->create([
        'order_product_id' => $product->id,
    ]);

    expect($image->product->id)->toBe($product->id);
});

test('OrderProductImage to creator', function () {
    $admin = Admin::factory()->create();
    Order::factory()->create();
    OrderProduct::factory()->create();
    $image = OrderProductImage::factory()->create([
        'created_by_id' => $admin->id,
    ]);

    expect($image->created_by->id)->toBe($admin->id);
});

test('OrderProductImage to updater', function () {
    $admin = Admin::factory()->create();
    Order::factory()->create();
    OrderProduct::factory()->create();
    $image = OrderProductImage::factory()->create([
        'updated_by_id' => $admin->id,
    ]);

    expect($image->updated_by->id)->toBe($admin->id);
});

test('Product to creator', function () {
    $admin = Admin::factory()->create();
    $product = Product::factory()->create([
        'created_by_id' => $admin->id,
    ]);

    expect($product->created_by->id)->toBe($admin->id);
});

test('Product to updater', function () {
    $admin = Admin::factory()->create();
    $product = Product::factory()->create([
        'updated_by_id' => $admin->id,
    ]);

    expect($product->updated_by->id)->toBe($admin->id);
});

test('Product to no thumbnail', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    $product = Product::factory()->create();

    expect($product->thumbnail)->toBe(null);
});

test('Product to thumbnail', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    $product = Product::factory()->create();
    $productImage = ProductImage::factory()->create();

    $product->thumbnail_id = $productImage->id;

    expect($product->thumbnail->id)->toBe($productImage->id);
});

test('Product to images', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    $product = Product::factory()->create();

    $expectedImages = ProductImage::factory()->count(4)->create([
        'product_id' => $product->id,
    ])
        ->map(function (ProductImage $image) {
            return $image->id;
        });

    $images = $product->images
        ->map(function (ProductImage $image) {
            return $image->id;
        });

    expect($expectedImages->all())->toBe($images->all());
});

test('Product to attributes', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    $product = Product::factory()->create();

    $expectedAttributes = ProductAttribute::factory()->count(4)->create([
        'product_id' => $product->id,
    ])
        ->map(function (ProductAttribute $attribute) {
            return $attribute->id;
        });

    $attributes = $product->productAttributes
        ->map(function (ProductAttribute $attribute) {
            return $attribute->id;
        });

    expect($attributes)->toEqual($expectedAttributes);
});

test('Product to category', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    $category = ProductCategory::factory()->create(['name' => 'Test', 'icon_id' => Icon::first()->id]);
    $product = Product::factory()->create([
        'product_category_id' => $category->id,
    ]);

    expect($product->category->id)->toBe($category->id);
});

test('ProductAttribute to product', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);

    $product = Product::factory()->create();
    $attribute = ProductAttribute::factory()->create([
        'product_id' => $product->id,
    ]);

    expect($attribute->product->id)->toBe($product->id);
});

test('ProductImage to creator', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    Product::factory()->create();
    $productImage = ProductImage::factory()->create([
        'created_by_id' => $admin->id,
    ]);

    expect($productImage->created_by->id)->toBe($admin->id);
});

test('ProductImage to updater', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    Product::factory()->create();
    $productImage = ProductImage::factory()->create([
        'updated_by_id' => $admin->id,
    ]);

    expect($productImage->updated_by->id)->toBe($admin->id);
});

test('ProductImage to product', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);

    $product = Product::factory()->create();
    $image = ProductImage::factory()->create([
        'product_id' => $product->id,
    ]);

    expect($image->product->id)->toBe($product->id);
});
