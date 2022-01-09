<?php

namespace App\Contracts;

use App\Models\Order;

interface ConvertableToOrder
{
    /**
     * Find an existing equivalent object for {@link Order}s or
     * create a new equivalent object
     * @return mixed
     */

    public function getOrderEquivalent(array $attributes = []);

    /**
     * Find an existing equivalent object for {@link Order}s
     * @return mixed
     */

    public function findOrderEquivalent();
}
