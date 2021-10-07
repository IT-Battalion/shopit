<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\CouponCode
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode query()
 * @mixin \Eloquent
 * @property string $id
 * @property int $discount
 * @property int $enabled
 * @property string $enabled_until
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereEnabledUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereUpdatedAt($value)
 * @property-read \App\Models\User|null $created_by
 * @property-read \App\Models\User|null $updated_by
 */
class CouponCode extends Model
{
    use UuidKey;

    protected $fillable = [
        'discount',
        'enabled',
        'enabled_until',
    ];

    public function created_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function createWith(User $user): CouponCode
    {
        $this->created_by = $user;
        $this->updated_by = $user;
        return $this;
    }

    public function updated_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function updateWith(User $user): CouponCode
    {
        $this->updated_by = $user;
        return $this;
    }
}
