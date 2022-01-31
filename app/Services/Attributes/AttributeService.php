<?php

namespace App\Services\Attributes;

use App\Types\AttributeType;
use Illuminate\Support\Collection;

class AttributeService implements AttributeServiceInterface
{
    /**
     * @inheritDoc
     */
    public function getActualSelectedAttributes(Collection $attributes): Collection {
        return $attributes->map(function ($attribute, $type) {
            if (is_int($attribute))
                return AttributeType::from($type)->getModelClass()::find($attribute);
            else
                return $attribute;
        });
    }

    /**
     * @inheritdoc
     */
    public function getIdsOfSelectedAttributes(Collection $attributes): Collection
    {
        return $attributes->map(function ($attribute) {
            if (is_int($attribute))
                return $attribute;
            else
                return $attribute->id;
        });
    }
}
