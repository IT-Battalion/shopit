<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Order
 *
 * @property string $id
 * @property User|null $owner
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
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAuthorizingAdmin($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCuponCodeId($value)
 * @method static Builder|Order whereHandedOverAt($value)
 * @method static Builder|Order whereHandedOverBy($value)
 * @method static Builder|Order whereOwner($value)
 * @method static Builder|Order wherePayedAt($value)
 * @method static Builder|Order wherePrice($value)
 * @method static Builder|Order whereRecievedAt($value)
 * @method static Builder|Order whereRecievedBy($value)
 * @method static Builder|Order whereTransactionConfirmedBy($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $customer
 * @property string $coupon_code_id
 * @property string|null $received_at
 * @property User|null $received_by
 * @property-read CouponCode|null $coupon_code
 * @method static Builder|Order whereCouponCodeId($value)
 * @method static Builder|Order whereCustomer($value)
 * @method static Builder|Order whereReceivedAt($value)
 * @method static Builder|Order whereReceivedBy($value)
 * @property string|null $products_ordered_at
 * @property int|null $products_ordered_by
 * @method static Builder|Order whereProductsOrderedAt($value)
 * @method static Builder|Order whereProductsOrderedBy($value)
 */
class Order extends Model
{
    use Prunable, HasFactory;

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

    private static function olderThan($column, $years)
    {
        return static::whereTime(
            $column,
            '<=',
            now()->subYears($years)
        );
    }

    public function prunable()
    {
        if (config('shop.invoice.delete_after_invoice_retention_period')) {
            return static::olderThan(
                'handed_over_at',
                config('shop.invoice.invoice_retention_period'));
        }
        return static::whereRaw('1=0'); // Don't delete anything
    }
}
