<?php

namespace App\Services\Orders;

use App\Events\OrderDeliveredEvent;
use App\Events\OrderOrderedEvent;
use App\Events\OrderPaidEvent;
use App\Events\OrderReceivedEvent;
use App\Exceptions\OrderNotOrderedException;
use App\Exceptions\OrderNotPaidException;
use App\Exceptions\OrderNotReceivedException;
use App\Exceptions\ShoppingCartEmptyException;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShoppingCartEntry;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use App\Types\OrderStatus;
use Illuminate\Support\Facades\Auth;

class OrderService implements OrderServiceInterface
{
    public function __construct(private ShoppingCartServiceInterface $shoppingCartService)
    {
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

        $prices = $this->shoppingCartService->calculateShoppingCartPrice($customer);

        $order = Order::create([
            'customer_id' => $customer->id,
            'coupon_code_id' => $coupon,
            'status' => OrderStatus::CREATED,
            'totalGross' => $prices['subtotal'],
            'totalDiscount' => $prices['discount'],
            'totalTax' => $prices['tax'],
            'total' => $prices['total'],
        ]);

        /** @var Product $product */
        foreach ($products as $product) {
            /** @var ShoppingCartEntry $metadata */
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
        $order->status = OrderStatus::PAID;
        $order->save();
        event(new OrderPaidEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotPaidException
     */
    public function markOrderAsOrdered(Order $order): Order
    {
        if (!$order->isPaid()) {
            throw new OrderNotPaidException('Die Bestellung wurde noch nicht bezahlt.');
        }

        $order->products_ordered_at = now();
        $order->products_ordered_by_id = Auth::user()->id;
        $order->status = OrderStatus::ORDERED;
        $order->save();

        event(new OrderOrderedEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotOrderedException
     */
    public function markOrderAsReceived(Order $order): Order
    {
        if (!$order->isOrdered()) {
            throw new OrderNotOrderedException('Die Bestellung wurde noch nicht von einem Administrator bestellt.');
        }

        $order->products_received_at = now();
        $order->products_received_by_id = Auth::user()->id;
        $order->status = OrderStatus::RECEIVED;
        $order->save();

        event(new OrderReceivedEvent($order));
        return $order;
    }

    /**
     * @throws OrderNotReceivedException
     */
    public function markOrderAsDelivered(Order $order): Order
    {
        if (!$order->isReceived()) {
            throw new OrderNotReceivedException('Die Bestellung wurde noch nicht von einem Administrator erhalten.');
        }

        $order->handed_over_at = now();
        $order->handed_over_by_id = Auth::user()->id;
        $order->status = OrderStatus::HANDED_OVER;
        $order->save();

        event(new OrderDeliveredEvent($order));
        return $order;
    }
}
