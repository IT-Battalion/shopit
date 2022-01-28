<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Contracts\ConvertableToOrder;
use App\Traits\TracksModification;
use App\Types\AttributeType;
use App\Types\Money;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

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

    // attributes

    public function areAttributesAvailable(\Illuminate\Support\Collection $attributes): bool
    {
        foreach ($attributes as $type => $attribute) {
            if (!$this->isAttributeAvailable($type, $attribute))
                return false;
        }

        return true;
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

    #[ArrayShape(['id' => "int", 'name' => "string", 'description' => "string", 'price' => "\App\Types\Money", 'tax' => "mixed", 'thumbnail' => "int[]|null[]", 'images' => "mixed", 'attributes' => "\Illuminate\Database\Eloquent\Collection"])]
    public function jsonSerialize(): array
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

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
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

    public function getRouteKeyName()
    {
        return 'name';
    }
}
