<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use UuidKey;

    protected $fillable = [
        'name'
    ];

    protected $table = 'product_categories';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
