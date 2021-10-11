<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class OrderProductAttribute extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_product_id';

    protected $fillable = [
        'type',
        'values_chosen',
    ];
}
