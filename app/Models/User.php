<?php

namespace App\Models;

use App\Events\UserBannedEvent;
use App\Events\UserBanningEvent;
use App\Events\UserUnbannedEvent;
use App\Events\UserUnbanningEvent;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\HasLdapUser;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Models\Model;

/**
 * App\Models\User
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
 * @property int|null $disabled_by;
 * @property string|null $guid
 * @property string|null $domain
 * @property-read Collection|CouponCode[] $coupons_updated
 * @property-read int|null $coupons_updated_count
 * @property-read Model|null $ldap
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|ProductImage[] $product_images_updated
 * @property-read int|null $product_images_updated_count
 * @property-read Collection|Product[] $products_updated
 * @property-read int|null $products_updated_count
 * @property-read Collection|ShoppingCart[] $shopping_cart
 * @property-read int|null $shopping_cart_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User notBanned()
 * @method static Builder|User onlyTrashed()
 * @method static Builder|User query()
 * @method static Builder|User student()
 * @method static Builder|User teacher()
 * @method static Builder|User whereClass($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereDisabledAt($value)
 * @method static Builder|User whereDomain($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmployeeType($value)
 * @method static Builder|User whereEnabled($value)
 * @method static Builder|User whereFirstname($value)
 * @method static Builder|User whereGuid($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereLang($value)
 * @method static Builder|User whereLastname($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereReasonForDisabling($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|User whereDisabledBy($value)
 * @property int|null $disabled_by_id
 * @method static Builder|User whereDisabledById($value)
 * @property string|null $disabled_at
 * @property-read CouponCode|null $shopping_cart_coupon
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDisabledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereShoppingCartCoupon($value)
 * @property int|null $shopping_cart_coupon_id
 * @method static \Illuminate\Database\Eloquent\Builder|User whereShoppingCartCouponId($value)
 */
class User extends Authenticatable implements LdapAuthenticatable
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Das is hässlich wie sau no joke
     * @return Builder
     */
    public function prunable(): Builder
    {
        return static::whereNotNull('deleted_at')
            ->whereRaw('(SELECT customer_id FROM orders
        WHERE users.id = orders.customer_id
        GROUP BY customer_id) IS NULL'); // An diese Query wird ein ORDER BY `id` angehängt was JOINS unmöglich macht,
        // da dies nicht zwischen der orders.id und der users.id unterscheiden könnte
        // deswegen die Subquery. Die Subquery ist in raw SQL, da der Query Builder für
        // Subqueries keine Möglichkeit bietet mit IS NULL zu vergleichen
    }

    public function shopping_cart(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'shopping_cart')
            ->withPivot(['count']);
    }

    public function shopping_cart_coupon(): BelongsTo
    {
        return $this->belongsTo(CouponCode::class, 'shopping_cart_coupon_id');
    }

    public function orders(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function scopeTeacher(Builder $query): Builder
    {
        return $query->where('employeeType', '=', 'lehrer');
    }

    public function scopeStudent(Builder $query): Builder
    {
        return $query->where('employeeType', '=', 'schueler');
    }

    public function scopeBanned(Builder $query): Builder
    {
        return $query->where('enabled', '=', false);
    }

    public function scopeNotBanned(Builder $query): Builder
    {
        return $query->where('enabled', '=', true);
    }

    public function banWith(Admin $admin)
    {
        $this->disabled_by_id = $admin->id;
    }

    public function unbanWith(Admin $admin = null)
    {
        $this->disabled_by_id = null;
    }

    public static function unbanning($callback)
    {
        static::registerModelEvent(UserUnbanningEvent::class, $callback);
    }

    public static function unbanned($callback)
    {
        static::registerModelEvent(UserUnbannedEvent::class, $callback);
    }

    public static function banning($callback)
    {
        static::registerModelEvent(UserBanningEvent::class, $callback);
    }

    public static function banned($callback)
    {
        static::registerModelEvent(UserBannedEvent::class, $callback);
    }
}
