<?php

namespace App\Services\Attributes;

use App\Contracts\Attribute;
use Illuminate\Support\Collection;

interface AttributeServiceInterface
{
    /**
     * Converts a structure of type [ AttributeTypeInt => AttributeId ] to [ AttributeTypeInt => {@link Attribute} ]
     * @param Collection $attributes
     * @return Collection
     */
    public function getActualSelectedAttributes(Collection $attributes): Collection;
}
