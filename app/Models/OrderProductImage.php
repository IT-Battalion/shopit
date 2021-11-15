<?php

namespace App\Models;

use Database\Factories\OrderProductImageFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderProductImage
 *
 * @property int $id
 * @property string $path
 * @property string $type
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $order_product_id
 * @property-read User $created_by
 * @property-read OrderProduct $product
 * @property-read User $updated_by
 * @method static OrderProductImageFactory factory(...$parameters)
 * @method static Builder|OrderProductImage newModelQuery()
 * @method static Builder|OrderProductImage newQuery()
 * @method static Builder|OrderProductImage query()
 * @method static Builder|OrderProductImage whereCreatedAt($value)
 * @method static Builder|OrderProductImage whereCreatedById($value)
 * @method static Builder|OrderProductImage whereId($value)
 * @method static Builder|OrderProductImage whereOrderProductId($value)
 * @method static Builder|OrderProductImage wherePath($value)
 * @method static Builder|OrderProductImage whereType($value)
 * @method static Builder|OrderProductImage whereUpdatedAt($value)
 * @method static Builder|OrderProductImage whereUpdatedById($value)
 * @mixin Eloquent
 */
class OrderProductImage extends Model
{
    use HasFactory;

    protected $table = 'order_product_images';

    protected $fillable = [
        'path',
        'type',
        'order_product_id',
    ];

    protected $casts = [
        'created_by_id' => 'integer',
        'updated_by_id' => 'integer',
        'order_product_id' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
