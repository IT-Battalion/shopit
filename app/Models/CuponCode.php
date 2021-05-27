<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;

class CuponCode extends Model
{
    use UuidKey;

    protected $fillable = [
        'discount',
        'enabled',
        'enabled_until',
    ];
}
