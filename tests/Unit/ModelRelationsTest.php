<?php

use App\Models\Admin;
use App\Models\CouponCode;
use App\Models\HighlightedProduct;
use App\Models\Icon;
use App\Models\Order;
use App\Models\OrderClothingAttribute;
use App\Models\OrderColorAttribute;
use App\Models\OrderDimensionAttribute;
use App\Models\OrderProduct;
use App\Models\OrderProductImage;
use App\Models\OrderVolumeAttribute;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductClothingAttribute;
use App\Models\ProductColorAttribute;
use App\Models\ProductDimensionAttribute;
use App\Models\ProductImage;
use App\Models\ProductVolumeAttribute;
use App\Models\User;
use App\Types\AttributeType;
use Illuminate\Support\Collection;

beforeEach(function () {
    $icon = Icon::factory()->create();
    Admin::factory()->create();
    ProductCategory::factory()->create(['name' => 'Test', 'icon_id' => $icon->id]);
    CouponCode::factory()->create();
});

test('admin relation to no created products', function () {
    $admin = Admin::factory()->create();

    $products = $admin->products_created->all();

    expect($products)->toEqual([]);
});

test('admin relation to created products', function () {
    $admin = Admin::factory()->create();

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
    $admin = Admin::factory()->create();
    $admin2 = Admin::factory()->create();

    Product::factory()->count(2)->create([
        'created_by_id' => $admin2->id,
        'updated_by_id' => $admin2->id,
    ]);

    $products = $admin->products_updated->all();

    expect($products)->toEqual([]);
});

test('admin relation to updated products', function () {
    $admin = Admin::factory()->create();
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
    $admin = Admin::factory()->create();

    $products = Product::factory()->count(2)->create();

    $products = $admin->shopping_cart->all();

    expect($products)->toEqual([]);
});

test('admin relation to products in the shopping cart', function () {
    $admin = Admin::factory()->create();

    $products = Product::factory()->count(2)->create();
    $admin->shopping_cart()->attach($products, ['count' => 2, 'values_chosen' => '[]']);

    $products = $admin->shopping_cart->all();

    expect($products)->toEqual($products);
});

test('admin relation to no orders', function () {
    $admin = Admin::factory()->create();

    $orders = $admin->orders->all();

    expect($orders)->toEqual([]);
});

test('admin relation to orders', function () {
    $admin = Admin::factory()->create();

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
    $user->shopping_cart()->attach($products, ['count' => 2, 'values_chosen' => '[]']);

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
    $admin = Admin::factory()->create();
    $admin2 = Admin::factory()->create();

    $coupon = CouponCode::factory()->create([
        'created_by_id' => $admin->id,
        'updated_by_id' => $admin2->id,
    ]);

    expect($coupon->created_by->id)->toBe($admin->id);
});

test('coupon relation to updater', function () {
    $admin = Admin::factory()->create();
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

    $expectedImages = OrderProductImage::factory()->count(4)->create()
        ->each(function (OrderProductImage $image) use ($product) {
            $product->images()->attach($image);
        })
        ->map(function (OrderProductImage $image) {
            return $image->id;
        });

    $images = $product->images
        ->map(function (OrderProductImage $image) {
            return $image->id;
        });

    expect($expectedImages->all())->toBe($images->all());
});

test('OrderProduct to no attributes', function () {
    Order::factory()->create();

    $expectedAttributes = [];

    $product = OrderProduct::factory()->create([
        'order_clothing_attribute_id' => null,
        'order_dimension_attribute_id' => null,
        'order_volume_attribute_id' => null,
        'order_color_attribute_id' => null,
    ]);

    expect($product->orderClothingAttribute)->toEqual(null);
    expect($product->orderDimensionAttribute)->toEqual(null);
    expect($product->orderVolumeAttribute)->toEqual(null);
    expect($product->orderColorAttribute)->toEqual(null);

    $attributes = $product->product_attributes
        ->map(fn ($attribute) => $attribute->id)
        ->all();

    expect($attributes)->toEqual($expectedAttributes);
    expect($attributes)->toHaveLength(sizeof($expectedAttributes));
});

test('OrderProduct to attributes', function () {
    Order::factory()->create();

    $expectedClothingAttribute = OrderClothingAttribute::factory()
        ->create();
    $expectedDimensionAttribute = OrderDimensionAttribute::factory()
        ->create();
    $expectedVolumeAttribute = OrderVolumeAttribute::factory()
        ->create();
    $expectedColorAttribute = OrderColorAttribute::factory()
        ->create();

    $expectedAttributes = [
        $expectedClothingAttribute->id,
        $expectedDimensionAttribute->id,
        $expectedVolumeAttribute->id,
        $expectedColorAttribute->id,
    ];

    $product = OrderProduct::factory()->create([
        'order_clothing_attribute_id' => $expectedClothingAttribute->id,
        'order_dimension_attribute_id' => $expectedDimensionAttribute->id,
        'order_volume_attribute_id' => $expectedVolumeAttribute->id,
        'order_color_attribute_id' => $expectedColorAttribute->id,
    ]);

    expect($product->orderClothingAttribute->id)->toEqual($expectedClothingAttribute->id);
    expect($product->orderDimensionAttribute->id)->toEqual($expectedDimensionAttribute->id);
    expect($product->orderVolumeAttribute->id)->toEqual($expectedVolumeAttribute->id);
    expect($product->orderColorAttribute->id)->toEqual($expectedColorAttribute->id);

    $attributes = $product->product_attributes
        ->map(fn ($attribute) => $attribute->id)
        ->all();

    expect($attributes)->toEqual($expectedAttributes);
    expect($attributes)->toHaveLength(sizeof($expectedAttributes));
});

test('OrderClothingAttribute to OrderProduct', function () {
    Order::factory()->create();

    $attribute = OrderClothingAttribute::factory()->create();

    $product = OrderProduct::factory()->create([
        'order_clothing_attribute_id' => $attribute->id,
    ]);

    expect($attribute->products->first()->id)->toEqual($product->id);
    expect($attribute->products->count())->toEqual(1);
});

test('OrderDimensionAttribute to OrderProduct', function () {
    Order::factory()->create();

    $attribute = OrderDimensionAttribute::factory()->create();

    $product = OrderProduct::factory()->create([
        'order_dimension_attribute_id' => $attribute->id,
    ]);

    expect($attribute->products->first()->id)->toEqual($product->id);
    expect($attribute->products->count())->toEqual(1);
});

test('OrderVolumeAttribute to OrderProduct', function () {
    Order::factory()->create();

    $attribute = OrderVolumeAttribute::factory()->create();

    $product = OrderProduct::factory()->create([
        'order_volume_attribute_id' => $attribute->id,
    ]);

    expect($attribute->products->first()->id)->toEqual($product->id);
    expect($attribute->products->count())->toEqual(1);
});

test('OrderColorAttribute to OrderProduct', function () {
    Order::factory()->create();

    $attribute = OrderColorAttribute::factory()->create();

    $product = OrderProduct::factory()->create([
        'order_color_attribute_id' => $attribute->id,
    ]);

    expect($attribute->products->first()->id)->toEqual($product->id);
    expect($attribute->products->count())->toEqual(1);
});

test('OrderProductImage to OrderProduct', function () {
    Order::factory()->create();
    $product = OrderProduct::factory()->create();
    $image = OrderProductImage::factory()->create();

    $product->images()->attach($image);

    expect($image->products->first()->id)->toBe($product->id);
    expect($image->products->count())->toBe(1);
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

    $expectedClothingAttributes = ProductClothingAttribute::factory()->count(4)->create();
    $expectedDimensionAttributes = ProductDimensionAttribute::factory()->count(4)->create();
    $expectedVolumeAttributes = ProductVolumeAttribute::factory()->count(4)->create();
    $expectedColorAttributes = ProductColorAttribute::factory()->count(4)->create();

    $expectedClothingAttributes->each(function (ProductClothingAttribute $clothingAttribute) use ($product) {
        $product->productClothingAttributes()->attach($clothingAttribute);
    });
    $expectedDimensionAttributes->each(function (ProductDimensionAttribute $clothingAttribute) use ($product) {
        $product->productDimensionAttributes()->attach($clothingAttribute);
    });
    $expectedVolumeAttributes->each(function (ProductVolumeAttribute $clothingAttribute) use ($product) {
        $product->productVolumeAttributes()->attach($clothingAttribute);
    });
    $expectedColorAttributes->each(function (ProductColorAttribute $clothingAttribute) use ($product) {
        $product->productColorAttributes()->attach($clothingAttribute);
    });

    $expectedAttributes =
        collect([
            AttributeType::CLOTHING => $expectedClothingAttributes,
            AttributeType::DIMENSION => $expectedDimensionAttributes,
            AttributeType::VOLUME => $expectedVolumeAttributes,
            AttributeType::COLOR => $expectedColorAttributes,
        ])
        ->map(fn (Collection $attributes) => $attributes->map(fn ($attribute) => $attribute->id))
        ->all();

    $attributes = $product->productAttributes
        ->map(fn (Collection $attributes) => $attributes->map(fn ($attribute) => $attribute->id))
        ->all();

    expect($attributes)->toEqual($expectedAttributes);
});

test('Product to no attributes', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    $product = Product::factory()->create();

    $expectedAttributes = [
        AttributeType::CLOTHING => [],
        AttributeType::DIMENSION => [],
        AttributeType::VOLUME => [],
        AttributeType::COLOR => [],
    ];

    $attributes = $product->productAttributes
        ->map(fn (Collection $attributes) => $attributes->map(fn ($attribute) => $attribute->id)->all())
        ->all();

    expect($attributes)->toEqual($expectedAttributes);
});

test('Product to category', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);
    $category = ProductCategory::factory()->create(['name' => 'Test2', 'icon_id' => Icon::first()->id]);
    $product = Product::factory()->create([
        'product_category_id' => $category->id,
    ]);

    expect($product->category->id)->toBe($category->id);
});

test('ProductClothingAttribute to product', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);

    $product = Product::factory()->create();
    $attribute = ProductClothingAttribute::factory()->create();

    $product->productClothingAttributes()->attach($attribute);
    $products = $attribute->products;

    expect($products->first()->id)->toBe($product->id);
    expect($products)->toHaveLength(1);
});

test('ProductDimensionAttribute to product', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);

    $product = Product::factory()->create();
    $attribute = ProductDimensionAttribute::factory()->create();

    $product->productDimensionAttributes()->attach($attribute);
    $products = $attribute->products;

    expect($products->first()->id)->toBe($product->id);
    expect($products)->toHaveLength(1);
});

test('ProductVolumeAttribute to product', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);

    $product = Product::factory()->create();
    $attribute = ProductVolumeAttribute::factory()->create();

    $product->productVolumeAttributes()->attach($attribute);
    $products = $attribute->products;

    expect($products->first()->id)->toBe($product->id);
    expect($products)->toHaveLength(1);
});

test('ProductColorAttribute to product', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin);

    $product = Product::factory()->create();
    $attribute = ProductColorAttribute::factory()->create();

    $product->productColorAttributes()->attach($attribute);
    $products = $attribute->products;

    expect($products->first()->id)->toBe($product->id);
    expect($products)->toHaveLength(1);
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
