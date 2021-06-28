<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Models\CouponCode;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use UuidKey;

    protected $fillable = [
        'price',
        'authorizing_admin',
        'recieved_at', //TODO received not recieved
        'recieved_by', //TODO received not recieved
        'payed_at',
        'transaction_confirmed_by',
        'handed_over_at',
        'handed_over_by',
    ];

    public function cupon_code(): HasOne //TODO: coupon not cupon
    {
        return $this->hasOne(CouponCode::class, 'id', 'cupon_code_id'); //TODO: coupon not cupon
    }

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'owner');
    }

    public function authorizing_admin(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'authorizing_admin');
    }

    public function recieved_by(): HasOne //TODO received not recieved
    {
        return $this->hasOne(User::class, 'id', 'recieved_by'); //TODO received not recieved
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
