<?php

namespace App\Services\Orders;

use App\Exceptions\ShoppingCartEmptyException;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShoppingCartEntry;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartServiceInterface;
use App\Types\OrderStatus;
use Carbon\Carbon;
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
            'subtotal' => $prices['subtotal'],
            'discount' => $prices['discount'],
            'tax' => $prices['tax'],
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

    /**
     * @param Order $order
     * @return void
     */
    public function incrementOrderStatus(Order $order)
    {
        $newStatus = OrderStatus::from($order->status->value + 1);

        $columns = $this->getStatusColums($newStatus, now(), Auth::id());

        $order->update(array_merge($columns,
            ['status' => $newStatus]));
    }

    private function getStatusColums(OrderStatus $status, Carbon $time = null, int $admin_id = null): array
    {
        return match ($status) {
            OrderStatus::CREATED => ['created_at' => now(), 'created_by' => $admin_id],
            OrderStatus::PAID => ['paid_at' => $time, 'transaction_confirmed_by_id' => $admin_id],
            OrderStatus::ORDERED => ['products_ordered_at' => $time, 'products_ordered_by_id' => $admin_id],
            OrderStatus::RECEIVED => ['products_received_at' => $time, 'products_received_by_id' => $admin_id],
            OrderStatus::HANDED_OVER => ['handed_over_at' => $time, 'handed_over_by_id' => $admin_id],
        };
    }

    /**
     * @param Order $order
     * @return void
     */
    public function decrementOrderStatus(Order $order)
    {
        $newStatus = OrderStatus::from($order->status->value - 1);

        $columns = $this->getStatusColums($order->status);

        $order->update(array_merge($columns,
            ['status' => $newStatus]));
    }
}
