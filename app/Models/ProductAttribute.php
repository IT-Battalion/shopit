<?php

namespace App\Models;

use Database\Factories\ProductAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductAttribute
 *
 * @property string $product_id
 * @property int $type
 * @property string $values_available
 * @method static Builder|ProductAttribute newModelQuery()
 * @method static Builder|ProductAttribute newQuery()
 * @method static Builder|ProductAttribute query()
 * @method static Builder|ProductAttribute whereProductId($value)
 * @method static Builder|ProductAttribute whereType($value)
 * @method static Builder|ProductAttribute whereValuesAvailable($value)
 * @mixin Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static ProductAttributeFactory factory(...$parameters)
 * @method static Builder|ProductAttribute whereCreatedAt($value)
 * @method static Builder|ProductAttribute whereId($value)
 * @method static Builder|ProductAttribute whereUpdatedAt($value)
 */
class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'values_available',
    ];
}
