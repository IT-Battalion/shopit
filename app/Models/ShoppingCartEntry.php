<?php

namespace App\Models;

use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\ShoppingCartEntry
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $count
 * @property array $values_chosen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ShoppingCartEntry newModelQuery()
 * @method static Builder|ShoppingCartEntry newQuery()
 * @method static Builder|ShoppingCartEntry query()
 * @method static Builder|ShoppingCartEntry whereCount($value)
 * @method static Builder|ShoppingCartEntry whereCreatedAt($value)
 * @method static Builder|ShoppingCartEntry whereId($value)
 * @method static Builder|ShoppingCartEntry whereProductId($value)
 * @method static Builder|ShoppingCartEntry whereUpdatedAt($value)
 * @method static Builder|ShoppingCartEntry whereUserId($value)
 * @method static Builder|ShoppingCartEntry whereValuesChosen($value)
 * @mixin Eloquent
 * @property int|null $product_clothing_attribute_id
 * @property int|null $product_dimension_attribute_id
 * @property int|null $product_volume_attribute_id
 * @property int|null $product_color_attribute_id
 * @property-read ProductClothingAttribute|null $productClothingAttribute
 * @property-read ProductColorAttribute|null $productColorAttribute
 * @property-read ProductDimensionAttribute|null $productDimensionAttribute
 * @property-read ProductVolumeAttribute|null $productVolumeAttribute
 * @method static Builder|ShoppingCartEntry whereProductClothingAttributeId($value)
 * @method static Builder|ShoppingCartEntry whereProductColorAttributeId($value)
 * @method static Builder|ShoppingCartEntry whereProductDimensionAttributeId($value)
 * @method static Builder|ShoppingCartEntry whereProductVolumeAttributeId($value)
 * @property-read mixed $has_product_clothing_attribute
 * @property-read mixed $has_product_color_attribute
 * @property-read mixed $has_product_dimension_attribute
 * @property-read mixed $has_product_volume_attribute
 * @property-read mixed $product_attributes
 * @property-read Product $product
 * @property-read User $user
 */
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
            ->filter(fn ($attribute) => isset($attribute));
    }

    public function productClothingAttribute()
    {
        return $this->belongsTo(ProductClothingAttribute::class);
    }

    public function getHasProductClothingAttributeAttribute()
    {
        return $this->productClothingAttribute()->exists();
    }

    public function productDimensionAttribute()
    {
        return $this->belongsTo(ProductDimensionAttribute::class);
    }

    public function getHasProductDimensionAttributeAttribute()
    {
        return $this->productDimensionAttribute()->exists();
    }

    public function productVolumeAttribute()
    {
        return $this->belongsTo(ProductVolumeAttribute::class);
    }

    public function getHasProductVolumeAttributeAttribute()
    {
        return $this->productVolumeAttribute()->exists();
    }

    public function productColorAttribute()
    {
        return $this->belongsTo(ProductColorAttribute::class);
    }

    public function getHasProductColorAttributeAttribute()
    {
        return $this->productColorAttribute()->exists();
    }

    public function convertAttributesToOrder(): Collection
    {
        return $this->product_attributes
            ->map(fn (ProductAttributeToOrder $attribute) => $attribute->getOrderEquivalent());
    }
}
