<?php

namespace App\Types;


use App\Traits\GetRandomEnumCase;

enum ClothingSize: int
{
    use GetRandomEnumCase;

    case XS = 0;
    case S = 1;
    case M = 2;
    case L = 3;
    case XL = 4;
}
