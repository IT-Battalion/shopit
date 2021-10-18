<?php

namespace App\Models;

use App\Util\BasicEnum;

class AttributeType extends BasicEnum
{
    /*
     * Clothing size
     */
    public const CLOTHING_SIZE = 0;

    /*
     * Product dimensions
     */
    public const DIMENSIONS = 1;

    /*
     * Volume in l
     */
    public const VOLUME = 2;

    /*
     * Product color
     */
    public const COLOR = 3;
}
