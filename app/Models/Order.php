<?php

namespace App\Models;

use Eloquent;
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
 * @property \App\Models\User $customer
 * @property int|null $coupon_code_id
 * @property string|null $payed_at
 * @property \App\Models\User $transaction_confirmed_by
 * @property string|null $products_ordered_at
 * @property int|null $products_ordered_by
 * @property string|null $received_at
 * @property \App\Models\User $received_by
 * @property string|null $handed_over_at
 * @property \App\Models\User $handed_over_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\CouponCode $coupon_code
 * @property-read \App\Models\User $ordered_by
 * @property-read Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static Builder|Order handedOver()
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order ordered()
 * @method static Builder|Order query()
 * @method static Builder|Order received()
 * @method static Builder|Order transactionConfirmed()
 * @method static Builder|Order whereCouponCodeId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCustomer($value)
 * @method static Builder|Order whereHandedOverAt($value)
 * @method static Builder|Order whereHandedOverBy($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order wherePayedAt($value)
 * @method static Builder|Order whereProductsOrderedAt($value)
 * @method static Builder|Order whereProductsOrderedBy($value)
 * @method static Builder|Order whereReceivedAt($value)
 * @method static Builder|Order whereReceivedBy($value)
 * @method static Builder|Order whereTransactionConfirmedBy($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use Prunable, HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'price',
        'customer',
        'coupon_code_id',
        'authorizing_admin',
        'received_at',
        'received_by',
        'payed_at',
        'transaction_confirmed_by',
        'handed_over_at',
        'handed_over_by',
    ];

    protected $casts = [
        'price' => 'float',
        'authorizing_admin' => 'integer',
        'received_by' => 'integer',
        'transaction_confirmed_by' => 'integer',
        'handed_over_by' => 'integer',
        'customer' => 'integer',
        'coupon_code_id' => 'integer',
    ];

    public function coupon_code(): BelongsTo
    {
        return $this->belongsTo(CouponCode::class, 'id', 'coupon_code_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'customer');
    }

    public function ordered_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'products_ordered_by');
    }

    public function received_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'received_by');
    }

    public function transaction_confirmed_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'transaction_confirmed_by');
    }

    public function handed_over_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'handed_over_by');
    }

    public function products(): HasOneOrMany
    {
        return $this
            ->hasMany(Product::class);
    }

    private static function olderThan($column, $years): \Illuminate\Database\Query\Builder
    {
        return static::whereTime(
            $column,
            '<=',
            now()->subYears($years)
        );
    }

    public function prunable(): \Illuminate\Database\Query\Builder
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
        return $query->whereNotNull('payed_at');
    }

    public function scopeReceived(Builder $query): Builder
    {
        return $query->whereNotNull('received_at');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->whereNotNull('products_ordered_at');
    }
}
