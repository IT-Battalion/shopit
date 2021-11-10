<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderProductAttribute
 *
 * @property int $id
 * @property int $order_product_id
 * @property int $type
 * @property string $values_chosen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Database\Factories\OrderProductAttributeFactory factory(...$parameters)
 * @method static Builder|OrderProductAttribute newModelQuery()
 * @method static Builder|OrderProductAttribute newQuery()
 * @method static Builder|OrderProductAttribute query()
 * @method static Builder|OrderProductAttribute whereCreatedAt($value)
 * @method static Builder|OrderProductAttribute whereId($value)
 * @method static Builder|OrderProductAttribute whereOrderProductId($value)
 * @method static Builder|OrderProductAttribute whereType($value)
 * @method static Builder|OrderProductAttribute whereUpdatedAt($value)
 * @method static Builder|OrderProductAttribute whereValuesChosen($value)
 * @mixin Eloquent
 */
class OrderProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'order_product_attributes';

    protected $fillable = [
        'type',
        'values_available',
        'order_product_id',
    ];

    protected $casts = [
        'type' => 'integer',
        'order_product_id' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'order_product_id', 'id');
    }
}
