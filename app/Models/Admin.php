<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\HasLdapUser;

class Admin extends User
{
    use Notifiable, AuthenticatesWithLdap, HasLdapUser, HasFactory, SoftDeletes, Prunable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'firstname',
        'lastname',
        'name',
        'employeeType',
        'class',
        'lang',
        'isAdmin',
        'enabled',
        'reason_for_disabling',
        'disabled_at',
        'disabled_by',
        'deleted_at',
        'guid',
        'domain',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('admin', function ($query) {
            $query->where('isAdmin', '=', true);
        });
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function product_images_updated(): HasOneOrMany
    {
        return $this->hasMany(ProductImage::class, 'updated_by_id');
    }

    public function coupons_updated(): HasOneOrMany
    {
        return $this->hasMany(CouponCode::class, 'updated_by_id');
    }

    public function products_created(): HasMany
    {
        return $this->hasMany(Product::class, 'created_by_id');
    }

    public function products_updated(): HasMany
    {
        return $this->hasMany(Product::class, 'updated_by_id');
    }

    public function product_images_created(): HasOneOrMany
    {
        return $this->hasMany(ProductImage::class, 'created_by_id');
    }

    public function order_transactions_approved(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'transaction_confirmed_by_id');
    }

    public function order_products_ordered(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'products_ordered_by_id');
    }

    public function order_received(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'products_received_by_id');
    }

    public function order_handed_over(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'handed_over_by_id');
    }

    public function coupons_created(): HasOneOrMany
    {
        return $this->hasMany(CouponCode::class, 'created_by_id');
    }
}
