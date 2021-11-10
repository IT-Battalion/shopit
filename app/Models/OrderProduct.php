<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\OrderProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $count
 * @property string $name
 * @property string $description
 * @property ProductImage|null $thumbnail
 * @property float $price
 * @property float $tax
 * @property int $available
 * @property User|null $created_by
 * @property User|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $order_product_category_id
 * @property-read Collection|OrderProductAttribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read OrderProductCategory $category
 * @property-read Collection|OrderProductImage[] $images
 * @property-read int|null $images_count
 * @method static OrderProductFactory factory(...$parameters)
 * @method static Builder|OrderProduct newModelQuery()
 * @method static Builder|OrderProduct newQuery()
 * @method static Builder|OrderProduct query()
 * @method static Builder|OrderProduct whereAvailable($value)
 * @method static Builder|OrderProduct whereCount($value)
 * @method static Builder|OrderProduct whereCreatedAt($value)
 * @method static Builder|OrderProduct whereCreatedBy($value)
 * @method static Builder|OrderProduct whereDescription($value)
 * @method static Builder|OrderProduct whereId($value)
 * @method static Builder|OrderProduct whereName($value)
 * @method static Builder|OrderProduct whereOrderId($value)
 * @method static Builder|OrderProduct whereOrderProductCategoryId($value)
 * @method static Builder|OrderProduct wherePrice($value)
 * @method static Builder|OrderProduct whereTax($value)
 * @method static Builder|OrderProduct whereThumbnail($value)
 * @method static Builder|OrderProduct whereUpdatedAt($value)
 * @method static Builder|OrderProduct whereUpdatedBy($value)
 * @mixin Eloquent
 */
class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'available',
        'tax',
        'order_product_category_id',
        'thumbnail',
        'order_id',
        'count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'float',
        'available' => 'integer',
        'tax' => 'float',
        'order_product_category_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'thumbnail' => 'integer',
        'order_id' => 'integer',
        'count' => 'integer',
    ];

    public function thumbnail(): HasOne
    {
        return $this->hasOne(OrderProductImage::class, 'id', 'thumbnail');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(OrderProductImage::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(OrderProductAttribute::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(OrderProductCategory::class);
    }
}
