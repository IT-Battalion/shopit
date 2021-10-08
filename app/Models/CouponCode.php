<?php

namespace App\Models;

use App\Traits\UuidKey;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\CouponCode
 *
 * @method static Builder|CouponCode newModelQuery()
 * @method static Builder|CouponCode newQuery()
 * @method static Builder|CouponCode query()
 * @mixin Eloquent
 * @property string $id
 * @property int $discount
 * @property int $enabled
 * @property string $enabled_until
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CouponCode whereCode($value)
 * @method static Builder|CouponCode whereCreatedAt($value)
 * @method static Builder|CouponCode whereDiscount($value)
 * @method static Builder|CouponCode whereEnabled($value)
 * @method static Builder|CouponCode whereEnabledUntil($value)
 * @method static Builder|CouponCode whereId($value)
 * @method static Builder|CouponCode whereUpdatedAt($value)
 * @property-read User|null $created_by
 * @property-read User|null $updated_by
 * @method static Builder|CouponCode whereCreatedBy($value)
 * @method static Builder|CouponCode whereUpdatedBy($value)
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
