<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Models\CouponCode;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Order
 *
 * @property string $id
 * @property User|null $owner
 * @property float $price
 * @property string $cupon_code_id
 * @property User|null $authorizing_admin
 * @property string|null $recieved_at
 * @property User|null $recieved_by
 * @property string|null $payed_at
 * @property User|null $transaction_confirmed_by
 * @property string|null $handed_over_at
 * @property User|null $handed_over_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read CouponCode|null $cupon_code
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAuthorizingAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCuponCodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereHandedOverAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereHandedOverBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePayedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRecievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRecievedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTransactionConfirmedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $customer
 * @property string $coupon_code_id
 * @property string|null $received_at
 * @property User|null $received_by
 * @property-read CouponCode|null $coupon_code
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponCodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceivedBy($value)
 */
class Order extends Model
{
    use UuidKey;

    protected $fillable = [
        'price',
        'authorizing_admin',
        'received_at',
        'received_by',
        'payed_at',
        'transaction_confirmed_by',
        'handed_over_at',
        'handed_over_by',
    ];

    public function coupon_code(): HasOne
    {
        return $this->hasOne(CouponCode::class, 'id', 'coupon_code_id');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'customer');
    }

    public function authorizing_admin(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'authorizing_admin');
    }

    public function received_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'received_by');
    }

    public function transaction_confirmed_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'transaction_confirmed_by');
    }

    public function handed_over_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'handed_over_by');
    }

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot(['count', 'discount'])
            ->withTimestamps();
    }
}
