<?php

namespace App\Models;

use App\Events\UserBannedEvent;
use App\Events\UserBanningEvent;
use App\Events\UserUnbannedEvent;
use App\Events\UserUnbanningEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\HasLdapUser;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;

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
        'lang',
        'is_admin',
        'enabled',
        'reason_for_disabling',
        'disabled_at',
        'disabled_by_id',
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
        'guid',
        'domain',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'bool',
        'enabled' => 'bool',
    ];

    public static function unbanned($callback)
    {
        static::registerModelEvent(UserUnbannedEvent::class, $callback);
    }

    public static function gotBanned($callback)
    {
        static::registerModelEvent(UserBannedEvent::class, $callback);
    }

    /**
     * Das is hässlich wie sau no joke
     * @return Builder
     */
    public function prunable()
    {
        return static::doesntHave('orders');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(CouponCode::class, 'shopping_cart_coupon_id');
    }

    public function orders(): HasOneOrMany
    {
        return $this->hasMany(Order::class, 'customer_id');
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
        $this->disabled_at = now();
        $this->enabled = false;
    }

    public function unbanWith(Admin $admin = null)
    {
        $this->disabled_by_id = null;
        $this->disabled_at = null;
        $this->enabled = true;
    }

    public function disabled_by()
    {
        return $this->belongsTo(Admin::class, 'disabled_by_id');
    }

    public function getBannableAttribute(): bool {
        return !$this->is_admin;
    }

    public function shopping_cart(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'shopping_cart', 'user_id')
            ->withPivot([
                'count',
                'product_clothing_attribute_id',
                'product_dimension_attribute_id',
                'product_volume_attribute_id',
                'product_color_attribute_id',
            ])
            ->using(ShoppingCartEntry::class);
    }

    public function asAdmin(): Admin {
        return Admin::find($this->id);
    }
}
