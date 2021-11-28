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
use Illuminate\Support\Facades\Auth;

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
        if ($products->count() === 0) throw new ShoppingCartEmptyException(t('error_messages.shopping_cart_empty'));
        $coupon = $customer->shopping_cart_coupon()->id ?? null;
        $order = Order::create([
            'customer_id' => $customer->id,
            'coupon_code_id' => $coupon,
        ]);
        foreach ($products as $product) {
            //will be removed when order categories are removed
            $order_product = OrderProduct::create(
                [
                    'name' => $product->name,
                    'description' => $product->description,
                    'count' => $product->pivot->count,
                    'created_at' => $product->created_at,
                    'created_by_id' => $product->created_by->id,
                    'order_id' => $order->id,
                    'price' => $product->price,
                    'tax' => $product->tax,
                ]);
            foreach ($product->images as $image) {
                $product_image = OrderProductImage::create([
                    'path' => $image->path,
                    'type' => $image->type,
                    'order_product_id' => $order_product->id,
                    'created_by_id' => $image->created_by,
                    'created_at' => $image->created_at,
                ]);

                if ($product->thumbnail === $image->id) {
                    $order_product->thumbnail = $product_image->id;
                    $order_product->save();
                }
            }
            foreach ($product->productAttributes as $attribute) {
                OrderProductAttribute::create([
                    'type' => $attribute->type,
                    'values_chosen' => $attribute->values_chosen,
                    'created_at' => $attribute->created_at,
                    'order_product_id' => $order_product->id,
                ]);
            }
            $this->shoppingCartService->removeProduct($product, user: $customer);
        }
        return $order;
    }

    public function markOrderAsPaid(Order $order): Order
    {
        $order->paid_at = now();
        $order->transaction_confirmed_by_id = Auth::user()->id;
        $order->save();
        event(new OrderPayingEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotPaidException
     */
    public function markOrderAsOrdered(Order $order): Order
    {
        if (!$order->isPaid())
        {
            throw new OrderNotPaidException(t('error_messages.order_not_paid'));
        }

        $order->products_ordered_at = now();
        $order->products_ordered_by_id = Auth::user()->id;
        $order->save();

        event(new OrderOrderingEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotOrderedException
     */
    public function markOrderAsReceived(Order $order): Order
    {
        if (!$order->isOrdered())
        {
            throw new OrderNotOrderedException(t('error_messages.order_not_ordered'));
        }

        $order->products_received_at = now();
        $order->products_received_by_id = Auth::user()->id;
        $order->save();

        event(new OrderReceivingEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotReceivedException
     */
    public function markOrderAsDelivered(Order $order): Order
    {
        if (!$order->isReceived())
        {
            throw new OrderNotReceivedException(t('error_messages.order_not_received'));
        }

        $order->handed_over_at = now();
        $order->handed_over_by_id = Auth::user()->id;
        $order->save();

        event(new OrderDeliveringEvent($order));
        return $order;
    }
}
