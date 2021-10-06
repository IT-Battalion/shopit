<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

/**
 * App\Models\HighlightedProduct
 *
 * @property string $id
 * @property string $product_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|HighlightedProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HighlightedProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HighlightedProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|HighlightedProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HighlightedProduct whereProductId($value)
 * @mixin \Eloquent
 */
class HighlightedProduct extends Model
{
    use UuidKey;

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
