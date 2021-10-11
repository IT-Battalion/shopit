<?php

namespace App\Models;

use App\Traits\UuidKey;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class ProductAttribute extends Model
{
    use UuidKey;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'type',
        'values_available',
    ];
}
