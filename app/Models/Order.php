<?php

namespace App\Models;

use App\Types\Money;
use App\Types\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use Prunable, HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'order_coupon_code_id',
        'status',

        'paid_at',
        'transaction_confirmed_by_id',
        'products_ordered_at',
        'products_ordered_by_id',
        'products_received_at',
        'products_received_by_id',
        'handed_over_at',
        'handed_over_by_id',

        'subtotal',
        'discount',
        'tax',
        'total',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'subtotal' => Money::class,
        'discount' => Money::class,
        'tax' => Money::class,
        'total' => Money::class,
    ];

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
            $model->products_received_at = now();
            if (!isset($model->products_received_by)) $model->products_received_by = Auth::user()->id;
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
        return $this->status->value >= OrderStatus::PAID->value;
    }

    public function isOrdered()
    {
        return $this->status->value >= OrderStatus::ORDERED->value;
    }

    public function isReceived()
    {
        return $this->status->value >= OrderStatus::RECEIVED->value;
    }

    public function isHandedOver()
    {
        return $this->status->value >= OrderStatus::HANDED_OVER->value;
    }

    public function products(): HasMany
    {
        return $this
            ->hasMany(OrderProduct::class);
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

    private static function olderThan($column, $years): \Illuminate\Database\Query\Builder
    {
        return static::whereTime(
            $column,
            '<=',
            now()->subYears($years)
        );
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

    public function scopeNotOrdered(Builder $query): Builder
    {
        return $query->where('status', '!=', OrderStatus::ORDERED);
    }
}
