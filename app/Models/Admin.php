<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $name
 * @property string $employeeType
 * @property string|null $class
 * @property string $lang
 * @property bool $isAdmin
 * @property bool $enabled
 * @property string|null $reason_for_disabling
 * @property string|null $disabled_at
 * @property Carbon|null $deleted_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $guid
 * @property string|null $domain
 * @property-read Collection|\App\Models\CouponCode[] $coupons_created
 * @property-read int|null $coupons_created_count
 * @property-read Collection|\App\Models\CouponCode[] $coupons_updated
 * @property-read int|null $coupons_updated_count
 * @property-read \LdapRecord\Models\Model|null $ldap
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|\App\Models\Order[] $order_handed_over
 * @property-read int|null $order_handed_over_count
 * @property-read Collection|\App\Models\Order[] $order_products_ordered
 * @property-read int|null $order_products_ordered_count
 * @property-read Collection|\App\Models\Order[] $order_received
 * @property-read int|null $order_received_count
 * @property-read Collection|\App\Models\Order[] $order_transactions_approved
 * @property-read int|null $order_transactions_approved_count
 * @property-read Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|\App\Models\ProductImage[] $product_images_created
 * @property-read int|null $product_images_created_count
 * @property-read Collection|\App\Models\ProductImage[] $product_images_updated
 * @property-read int|null $product_images_updated_count
 * @property-read Collection|\App\Models\Product[] $products_created
 * @property-read int|null $products_created_count
 * @property-read Collection|\App\Models\Product[] $products_updated
 * @property-read int|null $products_updated_count
 * @property-read Collection|\App\Models\ShoppingCart[] $shopping_cart
 * @property-read int|null $shopping_cart_count
 * @method static \Illuminate\Database\Eloquent\Builder|User banned()
 * @method static Builder|Admin newModelQuery()
 * @method static Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User notBanned()
 * @method static Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|User student()
 * @method static \Illuminate\Database\Eloquent\Builder|User teacher()
 * @method static Builder|Admin whereClass($value)
 * @method static Builder|Admin whereCreatedAt($value)
 * @method static Builder|Admin whereDeletedAt($value)
 * @method static Builder|Admin whereDisabledAt($value)
 * @method static Builder|Admin whereDomain($value)
 * @method static Builder|Admin whereEmail($value)
 * @method static Builder|Admin whereEmployeeType($value)
 * @method static Builder|Admin whereEnabled($value)
 * @method static Builder|Admin whereFirstname($value)
 * @method static Builder|Admin whereGuid($value)
 * @method static Builder|Admin whereId($value)
 * @method static Builder|Admin whereIsAdmin($value)
 * @method static Builder|Admin whereLang($value)
 * @method static Builder|Admin whereLastname($value)
 * @method static Builder|Admin whereName($value)
 * @method static Builder|Admin whereReasonForDisabling($value)
 * @method static Builder|Admin whereRememberToken($value)
 * @method static Builder|Admin whereUpdatedAt($value)
 * @method static Builder|Admin whereUsername($value)
 * @mixin Eloquent
 */
class Admin extends User
{
    protected $table = 'users';

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('admin', function ($query) {
            $query->where('isAdmin', '=', true);
        });
    }

    public function products_created(): HasOneOrMany
    {
        return $this->hasMany(Product::class, 'id', 'created_by');
    }

    public function product_images_created(): HasOneOrMany
    {
        return $this->hasMany(ProductImage::class, 'id', 'created_by');
    }

    public function order_transactions_approved(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'id', 'transaction_confirmed_by');
    }

    public function order_products_ordered(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'id', 'products_ordered_by');
    }

    public function order_received(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'id', 'received_by');
    }

    public function order_handed_over(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'id', 'handed_over_by');
    }

    public function coupons_created(): HasOneOrMany
    {
        return $this->hasMany(CouponCode::class, 'id', 'created_by');
    }
}
