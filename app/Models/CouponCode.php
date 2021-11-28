<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\CouponCodeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @property Carbon|null $enabled_until
 * @property string $code
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Admin $created_by
 * @property-read Collection|Order[] $orders_used
 * @property-read int|null $orders_used_count
 * @property-read Admin $updated_by
 * @method static Builder|CouponCode disabled()
 * @method static Builder|CouponCode enabled()
 * @method static CouponCodeFactory factory(...$parameters)
 * @method static Builder|CouponCode newModelQuery()
 * @method static Builder|CouponCode newQuery()
 * @method static Builder|CouponCode query()
 * @method static Builder|CouponCode whereCode($value)
 * @method static Builder|CouponCode whereCreatedAt($value)
 * @method static Builder|CouponCode whereCreatedById($value)
 * @method static Builder|CouponCode whereDiscount($value)
 * @method static Builder|CouponCode whereEnabled($value)
 * @method static Builder|CouponCode whereEnabledUntil($value)
 * @method static Builder|CouponCode whereId($value)
 * @method static Builder|CouponCode whereUpdatedAt($value)
 * @method static Builder|CouponCode whereUpdatedById($value)
 * @mixin Eloquent
 */
class CouponCode extends Model
{
    use HasFactory;

    protected $table = 'coupon_codes';

    protected $fillable = [
        'code',
        'discount',
        'enabled',
        'enabled_until',
    ];

    protected $casts = [
        'enabled' => 'bool',
    ];

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by_id');
    }

    public function updateWith(User $user): CouponCode
    {
        $this->updated_by_id = $user->id;
        return $this;
    }

    public function createWith(User $user): CouponCode
    {
        $this->created_by_id = $user->id;
        $this->updated_by_id = $user->id;
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
