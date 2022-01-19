<?php

namespace App\Contracts;

use App\Types\AttributeType;
use JsonSerializable;

interface Attribute extends JsonSerializable
{
    /**
     * Get all products that have this attribute
     */

    public function products();

    /**
     * Get the type of this attribute
     * @return AttributeType the attribute type
     */

    public function getTypeAttribute(): AttributeType;
}