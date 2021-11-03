<?php

namespace App\Models;

use Database\Factories\HighlightedProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static HighlightedProductFactory factory(...$parameters)
 * @method static Builder|HighlightedProduct whereCreatedAt($value)
 * @method static Builder|HighlightedProduct whereUpdatedAt($value)
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
