<?php

namespace App\Types;

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
}
