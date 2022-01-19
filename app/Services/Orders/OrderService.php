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
    public function createOrder(User $customer = null): Order
    {
        $customer = $customer ?? Auth::user();

        $products = $customer->shopping_cart;

        if ($products->count() === 0) throw new ShoppingCartEmptyException('Eine Bestellung kann nicht von einem leeren Einkaufswagen zusammengestellt werden.');

        $coupon = $customer->coupon?->id;

        $order = Order::create([
            'customer_id' => $customer->id,
            'coupon_code_id' => $coupon,
        ]);

        foreach ($products as $product) {
            $metadata = $product->pivot;

            // convert product to order product
            $orderProduct = $product->getOrderEquivalent([
                'count' => $product->pivot->count,
                'order_id' => $order->id,
            ]);

            // convert images and set thumbnail
            foreach ($product->images as $image) {
                $orderImage = $image->getOrderEquivalent();

                if ($product->thumbnail === $image->id) {
                    $orderProduct->thumbnail_id = $orderImage->id;
                    $orderProduct->save();
                }
            }

            $newAttributes = $metadata->convertAttributesToOrder();
            $orderProduct->product_attributes = $newAttributes;

            $this->shoppingCartService->removeProduct($product, $metadata->product_attributes, user: $customer);
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
            throw new OrderNotPaidException('Die Bestellung wurde noch nicht bezahlt.');
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
            throw new OrderNotOrderedException('Die Bestellung wurde noch nicht von einem Administrator bestellt.');
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
            throw new OrderNotReceivedException('Die Bestellung wurde noch nicht von einem Administrator erhalten.');
        }

        $order->handed_over_at = now();
        $order->handed_over_by_id = Auth::user()->id;
        $order->save();

        event(new OrderDeliveringEvent($order));
        return $order;
    }
}
