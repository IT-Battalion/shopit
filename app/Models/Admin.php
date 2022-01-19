<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\AdminFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\HasLdapUser;
use LdapRecord\Models\Model;

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
 * @property int $is_admin
 * @property int $enabled
 * @property string|null $reason_for_disabling
 * @property string|null $disabled_at
 * @property int|null $disabled_by_id
 * @property Carbon|null $deleted_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $guid
 * @property string|null $domain
 * @property-read Collection|CouponCode[] $coupons_created
 * @property-read int|null $coupons_created_count
 * @property-read Collection|CouponCode[] $coupons_updated
 * @property-read int|null $coupons_updated_count
 * @property-read Model|null $ldap
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Order[] $order_handed_over
 * @property-read int|null $order_handed_over_count
 * @property-read Collection|Order[] $order_products_ordered
 * @property-read int|null $order_products_ordered_count
 * @property-read Collection|Order[] $order_received
 * @property-read int|null $order_received_count
 * @property-read Collection|Order[] $order_transactions_approved
 * @property-read int|null $order_transactions_approved_count
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|ProductImage[] $product_images_created
 * @property-read int|null $product_images_created_count
 * @property-read Collection|ProductImage[] $product_images_updated
 * @property-read int|null $product_images_updated_count
 * @property-read Collection|Product[] $products_created
 * @property-read int|null $products_created_count
 * @property-read Collection|Product[] $products_updated
 * @property-read int|null $products_updated_count
 * @property-read Collection|Product[] $shopping_cart
 * @property-read int|null $shopping_cart_count
 * @method static Builder|User gotBanned()
 * @method static AdminFactory factory(...$parameters)
 * @method static Builder|Admin newModelQuery()
 * @method static Builder|Admin newQuery()
 * @method static Builder|User notBanned()
 * @method static \Illuminate\Database\Query\Builder|Admin onlyTrashed()
 * @method static Builder|Admin query()
 * @method static Builder|Admin student()
 * @method static Builder|Admin teacher()
 * @method static Builder|Admin whereClass($value)
 * @method static Builder|Admin whereCreatedAt($value)
 * @method static Builder|Admin whereDeletedAt($value)
 * @method static Builder|Admin whereDisabledAt($value)
 * @method static Builder|Admin whereDisabledById($value)
 * @method static Builder|Admin whereDomain($value)
 * @method static Builder|Admin whereEmail($value)
 * @method static Builder|Admin whereEmployeeType($value)
 * @method static Builder|Admin whereEnabled($value)
 * @method static Builder|Admin whereFirstname($value)
 * @method static Builder|Admin whereGuid($value)
 * @method static Builder|Admin whereId($value)
 * @method static Builder|Admin whereis_admin($value)
 * @method static Builder|Admin whereLang($value)
 * @method static Builder|Admin whereLastname($value)
 * @method static Builder|Admin whereName($value)
 * @method static Builder|Admin whereReasonForDisabling($value)
 * @method static Builder|Admin whereRememberToken($value)
 * @method static Builder|Admin whereShoppingCartCouponId($value)
 * @method static Builder|Admin whereUpdatedAt($value)
 * @method static Builder|Admin whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|Admin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Admin withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|User banned()
 * @property-read Admin|null $disabled_by
 * @method static Builder|Admin whereIsAdmin($value)
 * @property-read CouponCode|null $coupon
 */
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
        'is_admin',
        'enabled',
        'reason_for_disabling',
        'disabled_at',
        'disabled_by',
        'deleted_at',
        'guid',
        'domain',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function product_images_updated(): HasOneOrMany
    {
        return $this->hasMany(ProductImage::class,  'updated_by_id');
    }

    public function coupons_updated(): HasOneOrMany
    {
        return $this->hasMany(CouponCode::class, 'updated_by_id');
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('admin', function ($query) {
            $query->where('is_admin', '=', true);
        });
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
