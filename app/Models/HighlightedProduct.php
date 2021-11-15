<?php

namespace App\Models;

use Database\Factories\HighlightedProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\HighlightedProduct
 *
 * @property int $id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product $product
 * @method static HighlightedProductFactory factory(...$parameters)
 * @method static Builder|HighlightedProduct newModelQuery()
 * @method static Builder|HighlightedProduct newQuery()
 * @method static Builder|HighlightedProduct query()
 * @method static Builder|HighlightedProduct whereCreatedAt($value)
 * @method static Builder|HighlightedProduct whereId($value)
 * @method static Builder|HighlightedProduct whereProductId($value)
 * @method static Builder|HighlightedProduct whereUpdatedAt($value)
 * @mixin Eloquent
 */
class HighlightedProduct extends Model
{
    use HasFactory;

    protected $table = 'highlighted_products';

    protected $fillable = [
        'product_id'
    ];

    protected $casts = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
