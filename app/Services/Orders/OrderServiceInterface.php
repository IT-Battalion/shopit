<?php

namespace App\Services\Orders;

// TODO: implement a service that helps handling orders
// TODO: not here but Tests for every relation between models to verify that they work
// TODO: add default constructors to every model class
use App\Models\Order;
use App\Models\User;

interface OrderServiceInterface
{
    /**
     * Creates a new Order. Step 1.
     * @param User $customer The Customer of the Order.
     * @return Order The Order created.
     */
    public function createOrder(User $customer): Order;

    /**
     * Mark an Order as paid. Step 2
     * @param Order $order The Order which should be marked as Paid.
     * @return Order The edited Order Model.
     */
    public function markOrderAsPaid(Order $order): Order;

    /**
     * Mark an Order as Ordered by the Administrator. Step 3
     * @param Order $order The Order which should be marked as Ordered.
     * @return Order The edited Order Model.
     */
    public function markOrderAsOrdered(Order $order): Order;

    /**
     * Mark the Order as Received by the Administrator. Step 4
     * @param Order $order The Order which should be marked as Received.
     * @return Order The edited Order Model.
     */
    public function markOrderAsReceived(Order $order): Order;

    /**
     * Mark an Order as Delivered to the User by the Administrator. Step 5 (final)
     * @param Order $order The Order which should be marked as Delivered.
     * @return Order The edited Order Model.
     */
    public function markOrderAsDelivered(Order $order): Order;
}
