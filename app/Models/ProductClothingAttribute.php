<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use App\Types\ClothingSize;
use Database\Factories\ProductClothingAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\ClothingProductAttribute
 *
 * @property int $id
 * @property ClothingSize $size
 * @method static Builder|ProductClothingAttribute newModelQuery()
 * @method static Builder|ProductClothingAttribute newQuery()
 * @method static Builder|ProductClothingAttribute query()
 * @method static Builder|ProductClothingAttribute whereId($value)
 * @method static Builder|ProductClothingAttribute whereSize($value)
 * @mixin Eloquent
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static ProductClothingAttributeFactory factory(...$parameters)
 * @method static Builder|ProductClothingAttribute whereCreatedAt($value)
 * @method static Builder|ProductClothingAttribute whereUpdatedAt($value)
 * @property-read Collection|ShoppingCartEntry[] $shoppingCartEntries
 * @property-read int|null $shopping_cart_entries_count
 * @property-read mixed $type
 * @property-read OrderProductAttribute $order
 */
class ProductClothingAttribute extends Model implements ProductAttributeToOrder
{
    use HasFactory;

    protected $casts = [
        'size' => ClothingSize::class,
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'clothing_attribute');
    }

    public function shoppingCartEntries()
    {
        return $this->hasMany(ShoppingCartEntry::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::CLOTHING;
    }

    public function getOrderEquivalent(array $attributes = []): OrderProductAttribute
    {
        return $this->findOrderEquivalent() ??
            OrderClothingAttribute::create([
                'size' => $this->size,
            ]);
    }

    public function findOrderEquivalent(): OrderProductAttribute|null
    {
        return OrderClothingAttribute::whereSize($this->size)->first();
    }

    #[ArrayShape(['id' => "int", 'type' => "mixed", 'size' => "\App\Types\ClothingSize"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'size' => $this->size,
        ];
    }
}
