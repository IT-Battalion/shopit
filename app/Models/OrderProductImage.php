<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderProductImage
 *
 * @property string $id
 * @property string $path
 * @property string $type
 * @property User|null $created_by
 * @property User|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $order_product_id
 * @method static Builder|OrderProductImage newModelQuery()
 * @method static Builder|OrderProductImage newQuery()
 * @method static Builder|OrderProductImage query()
 * @method static Builder|OrderProductImage whereCreatedAt($value)
 * @method static Builder|OrderProductImage whereCreatedBy($value)
 * @method static Builder|OrderProductImage whereId($value)
 * @method static Builder|OrderProductImage whereOrderProductId($value)
 * @method static Builder|OrderProductImage wherePath($value)
 * @method static Builder|OrderProductImage whereType($value)
 * @method static Builder|OrderProductImage whereUpdatedAt($value)
 * @method static Builder|OrderProductImage whereUpdatedBy($value)
 * @mixin Eloquent
 */
class OrderProductImage extends ProductImage
{}
