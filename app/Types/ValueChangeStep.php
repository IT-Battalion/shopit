<?php

namespace App\Types;

use App\Traits\GetRandomEnumCase;

enum ValueChangeStep: string
{
    use GetRandomEnumCase;

    /** Increment the value */
    case INCREMENT = 'increment';

    /** Decrement the value */
    case DECREMENT = 'decrement';
}
