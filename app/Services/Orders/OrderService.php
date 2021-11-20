<?php

namespace App\Services\Orders;

use App\Events\OrderDeliveringEvent;
use App\Events\OrderOrderingEvent;
use App\Events\OrderPayingEvent;
use App\Events\OrderReceivingEvent;
use App\Exceptions\OrderNotOrderedException;
use App\Exceptions\OrderNotPaidException;
use App\Exceptions\OrderNotReceivedException;
use App\Exceptions\ShoppingCartEmptyException;
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

    /**
     * @throws ShoppingCartEmptyException
     */
    public function createOrder(User $customer): Order
    {
        $products = $customer->shopping_cart;
        if ($products->count() === 0) throw new ShoppingCartEmptyException(__('exceptionMessages.shopping_cart_empty'));
        $coupon = $customer->shopping_cart_coupon()->id ?? null;
        $order = Order::create([
            'customer' => $customer->id,
            'coupon_code_id' => $coupon,
        ]);
        foreach ($products as $product) {
            //will be removed when order categories are removed
            $order_product = OrderProduct::create(
                ['name' => $product->name,
                    'description' => $product->description,
                    'count' => $product->count,
                    'created_at' => $product->created_at,
                    'created_by' => $product->created_by,
                    'order_id' => $order->id,
                    'price' => $product->price,
                    'tax' => $product->tax
                ]);
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

    public function markOrderAsPaid(Order $order): Order
    {
        event(new OrderPayingEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotPaidException
     */
    public function markOrderAsOrdered(Order $order): Order
    {
        if (!isset($order->payed_at)) throw new OrderNotPaidException(__('exceptionMessages.order_not_paid'));
        event(new OrderOrderingEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotOrderedException
     */
    public function markOrderAsReceived(Order $order): Order
    {
        if (!isset($order->products_ordered_at)) throw new OrderNotOrderedException(__('exceptionMessages.order_not_ordered'));
        event(new OrderReceivingEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotReceivedException
     */
    public function markOrderAsDelivered(Order $order): Order
    {
        if (!isset($order->received_at)) throw new OrderNotReceivedException(__('exceptionMessages.order_not_received'));
        event(new OrderDeliveringEvent($order));
        return $order;
    }
}
