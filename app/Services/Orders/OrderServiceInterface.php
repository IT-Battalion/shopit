<?php

namespace App\Services\Orders;

// TODO: implement a service that helps handling orders
// TODO: not here but Tests for every relation between models to verify that they work
// TODO: add default constructors to every model class
interface OrderServiceInterface
{
    public function createOrder();

    public function deleteOrder();

    public function getOrder();
}
