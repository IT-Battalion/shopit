<?php

namespace App\Types;

use App\Traits\GetRandomEnumCase;

enum OrderStatus: int
{
    use GetRandomEnumCase;

    /** Just created, nothing more */
    case CREATED = 0;

    /** got paid, admin has to order */
    case PAID = 1;

    /** got ordered, waiting to receive */
    case ORDERED = 2;

    /** got received, waiting for pickup */
    case RECEIVED = 3;

    /** handed over to user */
    case HANDED_OVER = 4;
}
