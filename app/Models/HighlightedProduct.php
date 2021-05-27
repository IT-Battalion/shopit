<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;

class HighlightedProduct extends Model
{
    use UuidKey;

    public function products()
    {
        return $this->hasMany('App\\Models\\Product');
    }
}
