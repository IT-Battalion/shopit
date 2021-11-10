<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use LdapRecord\Models\Model;

/**
 * App\Models\OrderProductImage
 *
 * @property int $id
 * @property string $path
 * @property string $type
 * @property User|null $created_by
 * @property User|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $order_product_id
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
class OrderProductImage extends Model
{
    use HasFactory;

    protected $table = 'order_product_images';

    protected $fillable = [
        'path',
        'type',
        'product_id',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }
}
