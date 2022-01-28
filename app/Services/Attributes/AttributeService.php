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
        return $attributes->map(function ($attributeId, $type) {
            return AttributeType::from($type)->getModelClass()::find($attributeId);
        });
    }
}
