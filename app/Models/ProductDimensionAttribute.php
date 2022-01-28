<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use App\Types\Meter;
use Database\Factories\ProductDimensionAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\DimensionProductAttribute
 *
 * @method static Builder|ProductDimensionAttribute newModelQuery()
 * @method static Builder|ProductDimensionAttribute newQuery()
 * @method static Builder|ProductDimensionAttribute query()
 * @mixin Eloquent
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static ProductDimensionAttributeFactory factory(...$parameters)
 * @method static Builder|ProductDimensionAttribute whereCreatedAt($value)
 * @method static Builder|ProductDimensionAttribute whereUpdatedAt($value)
 * @property-read Collection|ShoppingCartEntry[] $shoppingCartEntries
 * @property-read int|null $shopping_cart_entries_count
 * @property-read mixed $type
 * @property-read OrderProductAttribute $order
 * @property int $id
 * @property Meter $width
 * @property Meter $height
 * @property Meter $depth
 * @method static Builder|ProductDimensionAttribute whereDepth($value)
 * @method static Builder|ProductDimensionAttribute whereHeight($value)
 * @method static Builder|ProductDimensionAttribute whereId($value)
 * @method static Builder|ProductDimensionAttribute whereWidth($value)
 */
class ProductDimensionAttribute extends Model implements ProductAttributeToOrder
{
    use HasFactory;

    protected $fillable = [
        'width',
        'height',
        'depth',
    ];

    protected $casts = [
        'width' => Meter::class,
        'height' => Meter::class,
        'depth' => Meter::class,
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'dimension_attribute');
    }

    public function shoppingCartEntries()
    {
        return $this->hasMany(ShoppingCartEntry::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::DIMENSION;
    }

    public function getOrderEquivalent(array $attributes = []): OrderProductAttribute
    {
        return $this->findOrderEquivalent() ??
            OrderDimensionAttribute::create([
                'width' => $this->width,
                'height' => $this->height,
                'depth' => $this->depth,
            ]);
    }

    public function findOrderEquivalent(): OrderProductAttribute|null
    {
        return OrderDimensionAttribute::query()
            ->where('width', $this->width->getValue())
            ->where('height', $this->height->getValue())
            ->where('depth', $this->depth->getValue())
            ->first();
    }

    #[ArrayShape(['id' => "int", 'type' => "mixed", 'width' => "\App\Types\Meter", 'height' => "\App\Types\Meter", 'depth' => "\App\Types\Meter"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'width' => $this->width,
            'height' => $this->height,
            'depth' => $this->depth,
        ];
    }
}
