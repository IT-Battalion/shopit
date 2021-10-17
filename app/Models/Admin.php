<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
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
 * @property bool $isAdmin
 * @property bool $enabled
 * @property string|null $reason_for_disabling
 * @property Carbon|null $deleted_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $guid
 * @property string|null $domain
 * @property-read Model|null $ldap
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Product[] $shopping_cart
 * @property-read int|null $shopping_cart_count
 * @method static Builder|Admin newModelQuery()
 * @method static Builder|Admin newQuery()
 * @method static Builder|Admin query()
 * @method static Builder|Admin whereClass($value)
 * @method static Builder|Admin whereCreatedAt($value)
 * @method static Builder|Admin whereDeletedAt($value)
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

        static::addGlobalScope(function ($query) {
            $query->where('isAdmin', true);
        });
    }
}