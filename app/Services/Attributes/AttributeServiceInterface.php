<?php

namespace App\Services\Attributes;

use App\Contracts\Attribute;
use Illuminate\Support\Collection;

interface AttributeServiceInterface
{
    /**
     * Converts a structure of type [ AttributeTypeInt => AttributeId ] or [ AttributeTypeInt => @link Attribute ] to [ AttributeTypeInt => @link Attribute ]
     * @param Collection $attributes
     * @return Collection
     */
    public function getActualSelectedAttributes(Collection $attributes): Collection;

    /**
     * Converts a structure of type [ AttributeTypeInt => @link Attribute ] or [ AttributeTypeInt => AttributeId ] to [ AttributeTypeInt => AttributeId ]
     * @param Collection $attributes
     * @return Collection
     */
    public function getIdsOfSelectedAttributes(Collection $attributes): Collection;
}
