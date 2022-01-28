<?php

namespace App\Models;

use App\Traits\TracksModification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class CouponCode extends Model
{
    use HasFactory, TracksModification;

    protected $table = 'coupon_codes';

    protected $fillable = [
        'code',
        'discount',
        'enabled',
        'enabled_until',
    ];

    protected $casts = [
        'discount' => 'string',
        'enabled' => 'bool',
    ];

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
