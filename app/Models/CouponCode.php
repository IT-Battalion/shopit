<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\CouponCode
 *
 * @property int $id
 * @property int $discount
 * @property bool $enabled
 * @property string $enabled_until
 * @property string $code
 * @property \App\Models\User|null $created_by
 * @property \App\Models\User|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Database\Factories\CouponCodeFactory factory(...$parameters)
 * @method static Builder|CouponCode newModelQuery()
 * @method static Builder|CouponCode newQuery()
 * @method static Builder|CouponCode query()
 * @method static Builder|CouponCode whereCode($value)
 * @method static Builder|CouponCode whereCreatedAt($value)
 * @method static Builder|CouponCode whereCreatedBy($value)
 * @method static Builder|CouponCode whereDiscount($value)
 * @method static Builder|CouponCode whereEnabled($value)
 * @method static Builder|CouponCode whereEnabledUntil($value)
 * @method static Builder|CouponCode whereId($value)
 * @method static Builder|CouponCode whereUpdatedAt($value)
 * @method static Builder|CouponCode whereUpdatedBy($value)
 * @mixin Eloquent
 */
class CouponCode extends Model
{
    use HasFactory;

    protected $table = 'coupon_codes';

    protected $fillable = [
        'code',
        'discount',
        'enabled_until',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }

    public function updateWith(User $user): CouponCode
    {
        $this->updated_by = $user->id;
        return $this;
    }

    public function createWith(User $user): CouponCode
    {
        $this->created_by = $user->id;
        $this->updated_by = $user->id;
        return $this;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (CouponCode $model) {
            if (!isset($model->created_by)) $model->createWith(Auth::user());
        });
        static::updating(function (CouponCode $model) {
            if (!isset($model->updated_by)) $model->updateWith(Auth::user());
        });
    }

    public function orders_used(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'id', 'coupon_code_id');
    }

    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('enabled', '=', true);
    }

    public function scopeDisabled(Builder $query): Builder
    {
        return $query->where('enabled', '=', false);
    }
}
