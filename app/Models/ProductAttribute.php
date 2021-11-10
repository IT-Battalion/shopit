<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductAttribute
 *
 * @property int $id
 * @property int $product_id
 * @property int $type
 * @property mixed $values_available
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Database\Factories\ProductAttributeFactory factory(...$parameters)
 * @method static Builder|ProductAttribute newModelQuery()
 * @method static Builder|ProductAttribute newQuery()
 * @method static Builder|ProductAttribute query()
 * @method static Builder|ProductAttribute whereCreatedAt($value)
 * @method static Builder|ProductAttribute whereId($value)
 * @method static Builder|ProductAttribute whereProductId($value)
 * @method static Builder|ProductAttribute whereType($value)
 * @method static Builder|ProductAttribute whereUpdatedAt($value)
 * @method static Builder|ProductAttribute whereValuesAvailable($value)
 * @mixin Eloquent
 */
class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';

    protected $fillable = [
        'type',
        'values_available',
        'product_id',
    ];

    protected $casts = [
        'type' => 'integer',
        'product_id' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
