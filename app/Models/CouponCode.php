<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CouponCode
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode query()
 * @mixin \Eloquent
 */
class CouponCode extends Model
{
    use UuidKey;

    protected $fillable = [
        'discount',
        'enabled',
        'enabled_until',
    ];
}
