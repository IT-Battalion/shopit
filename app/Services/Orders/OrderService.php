<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductAttribute;
use App\Models\OrderProductImage;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;

class OrderService implements OrderServiceInterface
{

    private ShoppingCartServiceInterface $shoppingCartService;

    public function __construct(ShoppingCartServiceInterface $shoppingCartService)
    {
        $this->shoppingCartService = $shoppingCartService;
    }

    public function createOrder(User $customer): Order
    {
        $products = $customer->shopping_cart();
        $coupon = $customer->shopping_cart_coupon_id;
        $order = Order::create([
            'customer' => $customer->id,
            'coupon_code_id' => $coupon
        ]);
        foreach ($products as $product) {
            $order_product_category = $product->category();
            $order_product = OrderProduct::create(['name' => $product->name, 'description' => $product->description, 'count' => $product->count, 'created_at' => $product->created_at, 'created_by' => $product->created_by, 'order_id' => $order->id, 'order_product_category_id' => $order_product_category->id, 'price' => $product->price, 'tax' => $product->tax]);
            foreach ($product->images() as $image) {
                $product_image = OrderProductImage::create(['path' => $image->path, 'type' => $image->type, 'order_product_id' => $order_product->id, 'created_by' => $image->created_by, 'created_at' => $image->created_at]);
                if ($product->thumbnail === $image->id) {
                    $order_product->thumbnail = $product_image->id;
                    $order_product->save();
                }
            }
            foreach ($product->attributes() as $attribute) {
                OrderProductAttribute::create(['type' => $attribute->type, 'values_chosen' => $attribute->values_chosen, 'created_at' => $attribute->created_at, 'order_product_id' => $order_product->id]);
            }
            $this->shoppingCartService->removeProduct($product);
        }
        return $order;
    }

    public function markOrderAsPayed(Order $order): Order
    {
        //event
    }

    public function markOrderAsOrdered(Order $order): Order
    {
        //event
    }

    public function markOrderAsReceived(Order $order): Order
    {
        //event
    }

    public function markOrderAsDelivered(Order $order): Order
    {
        //event
    }
}
