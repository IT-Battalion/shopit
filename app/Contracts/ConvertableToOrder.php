<?php

namespace App\Contracts;

use App\Models\Order;

interface ConvertableToOrder
{
    /**
     * Find an existing equivalent object for @link Orders or
     * create a new equivalent object
     * @return mixed
     */

    public function getOrderEquivalent(array $attributes = []);

    /**
     * Find an existing equivalent object for @link Orders
     * @return mixed
     */

    public function findOrderEquivalent();
}
