<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    use UuidKey;

    protected $fillable = [
        'discount',
        'enabled',
        'enabled_until',
    ];
}
