<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\User;

class OrderService implements OrderServiceInterface
{
    public function createOrder(User $customer): Order
    {
        // TODO: Implement createOrder() method.
    }

    public function markOrderAsPayed(Order $order): Order
    {
        // TODO: Implement markOrderAsPayed() method.
    }

    public function markOrderAsOrdered(Order $order): Order
    {
        // TODO: Implement markOrderAsOrdered() method.
    }

    public function markOrderAsReceived(Order $order): Order
    {
        // TODO: Implement markOrderAsReceived() method.
    }

    public function markOrderAsDelivered(Order $order): Order
    {
        // TODO: Implement markOrderAsDelivered() method.
    }
}
