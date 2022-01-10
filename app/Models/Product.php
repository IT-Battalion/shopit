<?php

namespace App\Models;

use App\Contracts\ConvertableToOrder;
use App\Types\AttributeType;
use App\Types\Money;
use Database\Factories\ProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $thumbnail_id
 * @property Money $price
 * @property string $tax
 * @property int $available
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $product_category_id
 * @property-read ProductCategory $category
 * @property-read User $created_by
 * @property-read Collection|ProductImage[] $images
 * @property-read int|null $images_count
 * @property-read int|null $product_attributes_count
 * @property-read ProductImage|null $thumbnail
 * @property-read User $updated_by
 * @method static Builder|Product available()
 * @method static ProductFactory factory(...$parameters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product unavailable()
 * @method static Builder|Product whereAvailable($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereCreatedById($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereProductCategoryId($value)
 * @method static Builder|Product whereTax($value)
 * @method static Builder|Product whereThumbnailId($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUpdatedById($value)
 * @mixin Eloquent
 * @property-read Collection $product_attributes
 * @property-read Collection|ProductClothingAttribute[] $productClothingAttributes
 * @property-read int|null $product_clothing_attributes_count
 * @property-read Collection|ProductColorAttribute[] $productColorAttributes
 * @property-read int|null $product_color_attributes_count
 * @property-read Collection|ProductDimensionAttribute[] $productDimensionAttributes
 * @property-read int|null $product_dimension_attributes_count
 * @property-read Collection|ProductVolumeAttribute[] $productVolumeAttributes
 * @property-read int|null $product_volume_attributes_count
 * @property-read mixed $main_thumbnail
 */
class Product extends Model implements ConvertableToOrder
{
    use HasFactory;

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
        'product_category_id',
        'thumbnail_id',
    ];

    protected $casts = [
        'price' => Money::class,
        'tax' => 'string',
    ];

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(ProductImage::class, 'thumbnail_id');
    }

    public function getMainThumbnailAttribute()
    {
        return $this->thumbnail ?? $this->images()->first();
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function createWith(User $user): Product
    {
        $this->created_by_id = $user->id;
        $this->updated_by_id = $user->id;
        return $this;
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function updateWith(User $user): Product
    {
        $this->updated_by_id = $user->id;
        return $this;
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getProductAttributesAttribute()
    {
        $clothingAttributes = $this->productClothingAttributes;
        $dimensionAttributes = $this->productDimensionAttributes;
        $volumeAttributes = $this->productVolumeAttributes;
        $colorAttributes = $this->productColorAttributes;

        return
            collect([
                AttributeType::CLOTHING => $clothingAttributes,
                AttributeType::DIMENSION => $dimensionAttributes,
                AttributeType::VOLUME => $volumeAttributes,
                AttributeType::COLOR => $colorAttributes,
            ]);
    }

    public function productClothingAttributes(): MorphToMany
    {
        return $this->morphedByMany(ProductClothingAttribute::class, 'product_attribute');
    }

    public function productDimensionAttributes(): MorphToMany
    {
        return $this->morphedByMany(ProductDimensionAttribute::class, 'product_attribute');
    }

    public function productVolumeAttributes(): MorphToMany
    {
        return $this->morphedByMany(ProductVolumeAttribute::class, 'product_attribute');
    }

    public function productColorAttributes(): MorphToMany
    {
        return $this->morphedByMany(ProductColorAttribute::class, 'product_attribute');
    }

    public function isAttributeAvailable(int $attributeType, $attribute): bool
    {
        $attributes = match ($attributeType) {
            AttributeType::CLOTHING => $this->productClothingAttributes(),
            AttributeType::DIMENSION => $this->productDimensionAttributes(),
            AttributeType::VOLUME => $this->productVolumeAttributes(),
            AttributeType::COLOR => $this->productColorAttributes(),
            default => null,
        };

        return ! is_null($attributes) && $attributes
                ->wherePivot('product_attribute_id', $attribute)
                ->count() !== 0;
    }

    public function areAttributesAvailable(\Illuminate\Support\Collection $attributes): bool
    {
        foreach ($attributes as $type => $attribute)
        {
            if ( ! $this->isAttributeAvailable($type, $attribute))
                return false;
        }

        return true;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Product $model) {
            if (!isset($model->created_by)) $model->createWith(Auth::user());
        });
        static::updating(function (Product $model) {
            if (!isset($model->updated_by)) $model->updateWith(Auth::user());
        });
        static::deleting(function (Product $model) {
            $model->images()->delete();
            $model->productAttributes()->delete();
        });
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('available', '>', '0')->orWhere('available', '=', '-1');
    }

    public function scopeUnavailable(Builder $query): Builder
    {
        return $query->where('available', '=', '0');
    }

    public function getOrderEquivalent(array $attributes = [])
    {
        return OrderProduct::create([
            'name' => $this->name,
            'description' => $this->description,
            'count' => $attributes['count'],
            'created_at' => $this->created_at,
            'created_by_id' => $this->created_by->id,
            'order_id' => $attributes['order_id'],
            'price' => $this->price,
            'tax' => $this->tax,
        ]);
    }

    public function findOrderEquivalent()
    {
        return null;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'description' => $this->name,
            'price' => $this->price,
            'tax' => $this->tax,
            'available' => $this->available,
            'thumbnail' => [
                'id' => $this->main_thumbnail?->id,
            ],
            'images' => $this->images->map(fn (ProductImage $image) => $image->id),
            'attributes' => $this->product_attributes,
        ];
    }

}
