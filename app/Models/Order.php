<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use UuidKey;

    protected $fillable = [
        'price',
        'authorizing_admin',
        'recieved_at',
        'recieved_by',
        'payed_at',
        'transaction_confirmed_by',
        'handed_over_at',
        'handed_over_by',
    ];

    public function cupon_code()
    {
        return $this->hasOne('App\\Models\\CuponCode', 'id', 'cupon_code_id');
    }

    public function owner()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'owner');
    }

    public function authorizing_admin()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'authorizing_admin');
    }

    public function recieved_by()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'recieved_by');
    }

    public function transaction_confirmed_by()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'transaction_confirmed_by');
    }

    public function handed_over_by()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'handed_over_by');
    }

    public function products()
    {
        return $this
            ->belongsToMany('App\\Models\\Product')
            ->withPivot(['count', 'discount'])
            ->withTimestamps();
    }
}
