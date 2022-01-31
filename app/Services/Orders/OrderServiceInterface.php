<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\User;
use App\Types\OrderStatus;

interface OrderServiceInterface
{
    /**
     * Creates a new Order. Step 1.
     * @param User|null $customer The Customer of the Order.
     * @return Order The Order created.
     */
    public function createOrder(User $customer = null): Order;

    /**
     * Increments the {@link OrderStatus} of an {@link Order}
     * @param Order $order the order to change
     * @return void
     */
    public function incrementOrderStatus(Order $order);

    /**
     * Decrements the {@link OrderStatus} of an {@link Order}
     * @param Order $order the order to change
     * @return void
     */
    public function decrementOrderStatus(Order $order);
}
