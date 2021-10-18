<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\HighlightedProduct
 *
 * @property string $id
 * @property string $product_id
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|HighlightedProduct newModelQuery()
 * @method static Builder|HighlightedProduct newQuery()
 * @method static Builder|HighlightedProduct query()
 * @method static Builder|HighlightedProduct whereId($value)
 * @method static Builder|HighlightedProduct whereProductId($value)
 * @mixin Eloquent
 */
class HighlightedProduct extends Model
{
    use HasFactory;

    protected $table = 'highlighted_products';

    protected $fillable = [
        'product_id'
    ];

    protected $casts = [
        'product_id' => 'integer'
    ];

    public function products(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
