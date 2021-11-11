<?php

namespace App\Models;

use App\Events\UserBannedEvent;
use App\Events\UserBanningEvent;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\HasLdapUser;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;

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
 * @property string|null $guid
 * @property string|null $domain
 * @property-read Collection|\App\Models\CouponCode[] $coupons_updated
 * @property-read int|null $coupons_updated_count
 * @property-read \LdapRecord\Models\Model|null $ldap
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|\App\Models\ProductImage[] $product_images_updated
 * @property-read int|null $product_images_updated_count
 * @property-read Collection|\App\Models\Product[] $products_updated
 * @property-read int|null $products_updated_count
 * @property-read Collection|\App\Models\ShoppingCart[] $shopping_cart
 * @property-read int|null $shopping_cart_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User notBanned()
 * @method static Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User student()
 * @method static \Illuminate\Database\Eloquent\Builder|User teacher()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDisabledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmployeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReasonForDisabling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin Eloquent
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
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'isAdmin' => 'boolean',
        'enabled' => 'boolean',
        'disabled_by' => 'integer',
    ];

    /**
     * Das is hässlich wie sau no joke
     * @return User
     */
    public function prunable(): User
    {
        return static::whereNotNull('deleted_at')
            ->whereRaw('(SELECT customer FROM orders
        WHERE users.id = orders.customer
        GROUP BY customer) IS NULL'); // An diese Query wird ein ORDER BY `id` angehängt was JOINS unmöglich macht,
        // da dies nicht zwischen der orders.id und der users.id unterscheiden könnte
        // deswegen die Subquery. Die Subquery ist in raw SQL, da der Query Builder für
        // Subqueries keine Möglichkeit bietet mit IS NULL zu vergleichen
    }

    public function product_images_updated(): HasOneOrMany
    {
        return $this->hasMany(ProductImage::class, 'id', 'updated_by');
    }

    public function products_updated(): HasOneOrMany
    {
        return $this->hasMany(Product::class, 'id', 'updated_by');
    }

    public function coupons_updated(): HasOneOrMany
    {
        return $this->hasMany(CouponCode::class, 'id', 'updated_by');
    }

    public function shopping_cart(): HasOneOrMany
    {
        return $this->hasMany(ShoppingCart::class, null, 'user_id');
    }

    public function orders(): HasOneOrMany
    {
        return $this->hasMany(Order::class, null, 'customer');
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
        $this->disabled_by = $admin->id;
    }

    public static function banning($callback)
    {
        static::registerModelEvent(UserBanningEvent::class, $callback);
    }

    public static function banned($callback)
    {
        static::registerModelEvent(UserBannedEvent::class, $callback);
    }

    protected static function boot()
    {
        parent::boot();
    }
}
