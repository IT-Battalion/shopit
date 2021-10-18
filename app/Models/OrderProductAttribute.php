<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderProductAttribute
 *
 * @property string $order_product_id
 * @property int $type
 * @property string $values_chosen
 * @method static Builder|OrderProductAttribute newModelQuery()
 * @method static Builder|OrderProductAttribute newQuery()
 * @method static Builder|OrderProductAttribute query()
 * @method static Builder|OrderProductAttribute whereOrderProductId($value)
 * @method static Builder|OrderProductAttribute whereType($value)
 * @method static Builder|OrderProductAttribute whereValuesChosen($value)
 * @mixin Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OrderProductAttribute whereCreatedAt($value)
 * @method static Builder|OrderProductAttribute whereId($value)
 * @method static Builder|OrderProductAttribute whereUpdatedAt($value)
 */
class OrderProductAttribute extends ProductAttribute
{
    protected $fillable = [
        'type',
        'values_chosen',
    ];
}
