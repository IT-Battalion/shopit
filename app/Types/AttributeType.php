<?php

namespace App\Types;

use BenSampo\Enum\Enum;

/**
 * @method static CLOTHING_SIZE()
 * @method static DIMENSIONS()
 * @method static VOLUME()
 * @method static COLOR()
 */
final class AttributeType extends Enum
{
    /*
     * Clothing size
     */
    public const CLOTHING = 0;

    /*
     * Product dimensions
     */
    public const DIMENSION = 1;

    /*
     * Volume in l
     */
    public const VOLUME = 2;

    /*
     * Product color
     */
    public const COLOR = 3;
}
