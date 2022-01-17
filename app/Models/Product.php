<?php

namespace App\Models;

use App\Contracts\ConvertableToOrder;
use App\Traits\TracksModification;
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

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $thumbnail_id
 * @property Money $price
 * @property-read Money $gross_price
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
 */
class Product extends Model implements ConvertableToOrder
{
    use HasFactory, TracksModification;

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

    protected $with = [
        'thumbnail',
        'category',
        'images',
        'productClothingAttributes',
        'productDimensionAttributes',
        'productVolumeAttributes',
        'productColorAttributes',
    ];

    // images
    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(ProductImage::class, 'thumbnail_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    // attributes
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

        return !is_null($attributes) && $attributes
            ->wherePivot('product_attribute_id', $attribute)
            ->count() !== 0;
    }

    public function areAttributesAvailable(\Illuminate\Support\Collection $attributes): bool
    {
        foreach ($attributes as $type => $attribute) {
            if (!$this->isAttributeAvailable($type, $attribute))
                return false;
        }

        return true;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('available', '>', '0')->orWhere('available', '=', '-1');
    }

    public function scopeUnavailable(Builder $query): Builder
    {
        return $query->where('available', '=', '0');
    }

    public function getGrossPriceAttribute(): Money
    {
        return $this->price->mul(bcadd($this->tax, 1));
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->name,
            'price' => $this->gross_price,
            'tax' => $this->tax,
            'available' => $this->available,
            'thumbnail' => [
                'id' => $this->thumbnail_id,
            ],
            'images' => $this->images->get('id'),
            'attributes' => $this->product_attributes,
        ];
    }

    public function deleteRelated()
    {
        $this->images()->delete();
        $this->productClothingAttributes()->delete();
        $this->productDimensionAttributes()->delete();
        $this->productVolumeAttributes()->delete();
        $this->productColorAttributes()->delete();
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
