<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $customer_id
 * @property int|null $coupon_code_id
 * @property string|null $paid_at
 * @property int|null $transaction_confirmed_by_id
 * @property string|null $products_ordered_at
 * @property int|null $products_ordered_by_id
 * @property string|null $products_received_at
 * @property int|null $products_received_by_id
 * @property string|null $handed_over_at
 * @property int|null $handed_over_by_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CouponCode|null $coupon_code
 * @property-read User $customer
 * @property-read User|null $handed_over_by
 * @property-read Collection|OrderProduct[] $products
 * @property-read int|null $products_count
 * @property-read User|null $products_ordered_by
 * @property-read User|null $products_received_by
 * @property-read User|null $transaction_confirmed_by
 * @method static OrderFactory factory(...$parameters)
 * @method static Builder|Order handedOver()
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order ordered()
 * @method static Builder|Order query()
 * @method static Builder|Order received()
 * @method static Builder|Order transactionConfirmed()
 * @method static Builder|Order whereCouponCodeId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCustomerId($value)
 * @method static Builder|Order whereHandedOverAt($value)
 * @method static Builder|Order whereHandedOverById($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order wherePaidAt($value)
 * @method static Builder|Order whereProductsOrderedAt($value)
 * @method static Builder|Order whereProductsOrderedById($value)
 * @method static Builder|Order whereProductsReceivedAt($value)
 * @method static Builder|Order whereProductsReceivedById($value)
 * @method static Builder|Order whereTransactionConfirmedById($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use Prunable, HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'price',
        'customer_id',
        'coupon_code_id',
        'authorizing_admin',
        'products_received_at',
        'products_received_by_id',
        'payed_at',
        'transaction_confirmed_by_id',
        'handed_over_at',
        'handed_over_by_id',
    ];

    protected $casts = [];

    public function coupon_code(): BelongsTo
    {
        return $this->belongsTo(CouponCode::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function products_ordered_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'products_ordered_by_id');
    }

    public function products_received_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'products_received_by_id');
    }

    public function transaction_confirmed_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'transaction_confirmed_by_id');
    }

    public function handed_over_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handed_over_by_id');
    }

    public function products(): HasOneOrMany
    {
        return $this
            ->hasMany(OrderProduct::class);
    }

    private static function olderThan($column, $years): \Illuminate\Database\Query\Builder
    {
        return static::whereTime(
            $column,
            '<=',
            now()->subYears($years)
        );
    }

    public function prunable(): Builder
    {
        if (config('shop.invoice.delete_after_invoice_retention_period')) {
            return static::olderThan(
                'handed_over_at',
                config('shop.invoice.invoice_retention_period'));
        }
        return static::whereRaw('1=0'); // Don't delete anything
    }

    public function scopeHandedOver(Builder $query): Builder
    {
        return $query->whereNotNull('handed_over_at');
    }

    public function scopeTransactionConfirmed(Builder $query): Builder
    {
        return $query->whereNotNull('paid_at');
    }

    public function scopeReceived(Builder $query): Builder
    {
        return $query->whereNotNull('products_received_at');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->whereNotNull('products_ordered_at');
    }
}
