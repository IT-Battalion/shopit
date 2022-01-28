<?php

namespace App\Models;

use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;

class ShoppingCartEntry extends Pivot
{
    protected $table = 'shopping_cart';

    protected $fillable = [
        'user_id',
        'product_id',
        'count',
        'product_clothing_attribute_id',
        'product_dimension_attribute_id',
        'product_volume_attribute_id',
        'product_color_attribute_id',
    ];

    protected $with = [
        'productClothingAttribute',
        'productDimensionAttribute',
        'productVolumeAttribute',
        'productColorAttribute',
    ];

    public function getProductAttributesAttribute()
    {
        $clothingAttribute = $this->productClothingAttribute;
        $dimensionAttribute = $this->productDimensionAttribute;
        $volumeAttribute = $this->productVolumeAttribute;
        $colorAttribute = $this->productColorAttribute;

        return
            collect([
                AttributeType::CLOTHING->value => $clothingAttribute,
                AttributeType::DIMENSION->value => $dimensionAttribute,
                AttributeType::VOLUME->value => $volumeAttribute,
                AttributeType::COLOR->value => $colorAttribute,
            ])
                ->filter(fn($attribute) => isset($attribute));
    }

    public function getHasProductClothingAttributeAttribute()
    {
        return $this->productClothingAttribute()->exists();
    }

    public function productClothingAttribute()
    {
        return $this->belongsTo(ProductClothingAttribute::class);
    }

    public function getHasProductDimensionAttributeAttribute()
    {
        return $this->productDimensionAttribute()->exists();
    }

    public function productDimensionAttribute()
    {
        return $this->belongsTo(ProductDimensionAttribute::class);
    }

    public function getHasProductVolumeAttributeAttribute()
    {
        return $this->productVolumeAttribute()->exists();
    }

    public function productVolumeAttribute()
    {
        return $this->belongsTo(ProductVolumeAttribute::class);
    }

    public function getHasProductColorAttributeAttribute()
    {
        return $this->productColorAttribute()->exists();
    }

    public function productColorAttribute()
    {
        return $this->belongsTo(ProductColorAttribute::class);
    }

    public function convertAttributesToOrder(): Collection
    {
        return $this->product_attributes
            ->map(fn(ProductAttributeToOrder $attribute) => $attribute->getOrderEquivalent());
    }
}
