<?php

namespace App\Models;

use App\Types\Money;
use App\Types\OrderStatus;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
 * @property OrderStatus $status
 * @property Money $totalGross
 * @property Money $totalDiscount
 * @property Money $totalTax
 * @property Money $total
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereTotal($value)
 * @method static Builder|Order whereTotalDiscount($value)
 * @method static Builder|Order whereTotalGross($value)
 * @method static Builder|Order whereTotalTax($value)
 */
class Order extends Model
{
    use Prunable, HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'order_coupon_code_id',
        'status',

        'authorizing_admin',
        'products_received_at',
        'products_received_by_id',
        'paid_at',
        'transaction_confirmed_by_id',
        'handed_over_at',
        'handed_over_by_id',

        'totalGross',
        'totalDiscount',
        'totalTax',
        'total',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'totalGross' => Money::class,
        'totalDiscount' => Money::class,
        'totalTax' => Money::class,
        'total' => Money::class,
    ];

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

    public function isPaid()
    {
        return $this->status === OrderStatus::PAID;
    }

    public function isOrdered()
    {
        return $this->status === OrderStatus::ORDERED;
    }

    public function isReceived()
    {
        return $this->status === OrderStatus::RECEIVED;
    }

    public function isHandedOver()
    {
        return $this->status === OrderStatus::HANDED_OVER;
    }

    public function products(): HasMany
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
        return $query->where('status', OrderStatus::HANDED_OVER);
    }

    public function scopeTransactionConfirmed(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::PAID);
    }

    public function scopeReceived(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::RECEIVED);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::ORDERED);
    }

    protected static function boot()
    {
        parent::boot();
        static::registerModelEvent('paying', function (Order $model) {
            $model->paid_at = now();
            if (!isset($model->transaction_confirmed_by)) $model->transaction_confirmed_by = Auth::user()->id;
        });
        static::registerModelEvent('paid', function () {
        });
        static::registerModelEvent('ordering', function (Order $model) {
            $model->products_ordered_at = now();
            if (!isset($model->products_ordered_by)) $model->products_ordered_by = Auth::user()->id;
        });
        static::registerModelEvent('ordered', function () {
        });
        static::registerModelEvent('receiving', function (Order $model) {
            $model->received_at = now();
            if (!isset($model->received_by)) $model->received_by = Auth::user()->id;
        });
        static::registerModelEvent('received', function () {
        });
        static::registerModelEvent('delivering', function (Order $model) {
            $model->handed_over_at = now();
            if (!isset($model->handed_over_by)) $model->handed_over_by = Auth::user()->id;
        });
        static::registerModelEvent('delivered', function () {
        });
    }
}
