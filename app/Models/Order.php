<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property string $id
 * @property User|null $owner
 * @property string $coupon_code_id
 * @property User|null $authorizing_admin
 * @property string|null $received_at
 * @property User|null $received_by
 * @property string|null $payed_at
 * @property User|null $transaction_confirmed_by
 * @property string|null $handed_over_at
 * @property User|null $handed_over_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CouponCode|null $coupon_code
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAuthorizingAdmin($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCouponCodeId($value)
 * @method static Builder|Order whereHandedOverAt($value)
 * @method static Builder|Order whereHandedOverBy($value)
 * @method static Builder|Order whereOwner($value)
 * @method static Builder|Order wherePayedAt($value)
 * @method static Builder|Order wherePrice($value)
 * @method static Builder|Order whereReceivedAt($value)
 * @method static Builder|Order whereReceivedBy($value)
 * @method static Builder|Order whereTransactionConfirmedBy($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $customer
 * @method static Builder|Order whereCustomer($value)
 * @property string|null $products_ordered_at
 * @property int|null $products_ordered_by
 * @method static Builder|Order whereProductsOrderedAt($value)
 * @method static Builder|Order whereProductsOrderedBy($value)
 * @property float $price
 * @method static Builder|Order whereId($value)
 * @method static OrderFactory factory(...$parameters)
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
