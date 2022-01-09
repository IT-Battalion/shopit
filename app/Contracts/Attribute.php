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
     * @return int the attribute type {@link AttributeType}
     */

    public function getTypeAttribute(): int;
}
