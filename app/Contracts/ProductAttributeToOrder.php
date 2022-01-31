<?php

namespace App\Contracts;

interface ProductAttributeToOrder extends Attribute, ConvertableToOrder
{
    /**
     * Get all shopping cart entries that have selected this attribute
     */

    public function shoppingCartEntries();

    /**
     * Find an existing equivalent @link OrderProductAttribute or
     * create an equivalent @link OrderProductAttribute
     * @return mixed
     */

    public function getOrderEquivalent(array $attributes = []): OrderProductAttribute;

    /**
     * Find an existing equivalent @link OrderProductAttribute
     * @return OrderProductAttribute|null
     */

    public function findOrderEquivalent(): OrderProductAttribute|null;
}
