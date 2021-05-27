<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use UuidKey;

    protected $fillable = [
        'name'
    ];

    protected $table = 'product_categories';

    public function products()
    {
        return $this->hasMany('App\\Models\\Product');
    }
}
