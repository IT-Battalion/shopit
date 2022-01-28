<?php

namespace App\Types;

use App\Models\ProductClothingAttribute;
use App\Models\ProductColorAttribute;
use App\Models\ProductDimensionAttribute;
use App\Models\ProductVolumeAttribute;
use App\Traits\GetRandomEnumCase;

enum AttributeType: int
{
    use GetRandomEnumCase;

    /*
     * Clothing size
     */
    case CLOTHING = 0;

    /*
     * Product dimensions
     */
    case DIMENSION = 1;

    /*
     * Volume in l
     */
    case VOLUME = 2;

    /*
     * Product color
     */
    case COLOR = 3;

    function getModelClass() {
        return match ($this) {
            AttributeType::CLOTHING => ProductClothingAttribute::class,
            AttributeType::DIMENSION => ProductDimensionAttribute::class,
            AttributeType::VOLUME => ProductVolumeAttribute::class,
            AttributeType::COLOR => ProductColorAttribute::class,
        };
    }
}
