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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\OrderProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $count
 * @property string $name
 * @property string $description
 * @property int|null $thumbnail_id
 * @property float $price
 * @property float $tax
 * @property int $available
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $order_product_category_id
 * @property-read User $created_by
 * @property-read Collection|OrderProductImage[] $images
 * @property-read int|null $images_count
 * @property-read Collection|OrderProductAttribute[] $productAttributes
 * @property-read int|null $product_attributes_count
 * @property-read OrderProductImage|null $thumbnail
 * @property-read User $updated_by
 * @method static OrderProductFactory factory(...$parameters)
 * @method static Builder|OrderProduct newModelQuery()
 * @method static Builder|OrderProduct newQuery()
 * @method static Builder|OrderProduct query()
 * @method static Builder|OrderProduct whereAvailable($value)
 * @method static Builder|OrderProduct whereCount($value)
 * @method static Builder|OrderProduct whereCreatedAt($value)
 * @method static Builder|OrderProduct whereCreatedById($value)
 * @method static Builder|OrderProduct whereDescription($value)
 * @method static Builder|OrderProduct whereId($value)
 * @method static Builder|OrderProduct whereName($value)
 * @method static Builder|OrderProduct whereOrderId($value)
 * @method static Builder|OrderProduct wherePrice($value)
 * @method static Builder|OrderProduct whereTax($value)
 * @method static Builder|OrderProduct whereThumbnailId($value)
 * @method static Builder|OrderProduct whereUpdatedAt($value)
 * @method static Builder|OrderProduct whereUpdatedById($value)
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
        'thumbnail_id',
        'order_id',
        'count',
        'created_by_id',
        'updated_by_id',
    ];

    protected $casts = [
        'price' => Money::class,
        'tax' => 'string',
    ];

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(OrderProductImage::class, 'thumbnail_id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(OrderProductImage::class);
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(OrderProductAttribute::class);
    }

    public function createWith(User $user): OrderProduct
    {
        $this->created_by_id = $user->id;
        $this->updated_by_id = $user->id;
        return $this;
    }

    public function updateWith(User $user): OrderProduct
    {
        $this->updated_by_id = $user->id;
        return $this;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (OrderProduct $model) {
            if (!isset($model->created_by)) $model->createWith(Auth::user());
            elseif (!isset($model->updated_by)) $model->updateWith(Auth::user());
        });
        static::updating(function (OrderProduct $model) {
            if (!isset($model->updated_by)) $model->updateWith(Auth::user());
        });
        static::deleting(function (OrderProduct $model) {
            $model->images()->delete();
            $model->productAttributes()->delete();
        });
    }
}
