<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
    use HasFactory, TracksModification, EagerLoadPivotTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'tax',
        'product_category_id',
        'thumbnail_id',
    ];

    protected $casts = [
        'price' => Money::class,
        'tax' => 'string',
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
                AttributeType::CLOTHING->value => $clothingAttributes,
                AttributeType::DIMENSION->value => $dimensionAttributes,
                AttributeType::VOLUME->value => $volumeAttributes,
                AttributeType::COLOR->value => $colorAttributes,
            ]);
    }

    public function productClothingAttributes(): BelongsToMany
    {
        return $this->belongsToMany(ProductClothingAttribute::class, 'clothing_attribute');
    }

    public function productDimensionAttributes(): BelongsToMany
    {
        return $this->belongsToMany(ProductDimensionAttribute::class, 'dimension_attribute');
    }

    public function productVolumeAttributes(): BelongsToMany
    {
        return $this->belongsToMany(ProductVolumeAttribute::class, 'volume_attribute');
    }

    public function productColorAttributes(): BelongsToMany
    {
        return $this->belongsToMany(ProductColorAttribute::class, 'color_attribute');
    }

    public function isAttributeAvailable(AttributeType|int $attributeType, $attribute): bool
    {
        if (is_int($attributeType)) {
            $attributeType = AttributeType::from($attributeType);
        }
        return DB::table(strtolower($attributeType->name) . '_attribute')
            ->where('product_id', $this->id)
            ->where('product_' . strtolower($attributeType->name) . '_attribute_id', getModelId($attribute))
            ->exists();
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
            'tax' => str_replace('.', ',', bcround(bcmul($this->tax, '100'))),
            'thumbnail' => [
                'id' => $this->thumbnail_id,
            ],
            'images' => $this->images->get('id'),
            'attributes' => $this->product_attributes,
        ];
    }

    public function jsonPreview()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->gross_price,
            'tax' => $this->tax,
            'thumbnail' => [
                'id' => $this->thumbnail_id,
            ],
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
