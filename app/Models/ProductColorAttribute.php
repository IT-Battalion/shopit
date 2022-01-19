<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use Database\Factories\ProductColorAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ColorProductAttribute
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @method static Builder|ProductColorAttribute newModelQuery()
 * @method static Builder|ProductColorAttribute newQuery()
 * @method static Builder|ProductColorAttribute query()
 * @method static Builder|ProductColorAttribute whereColor($value)
 * @method static Builder|ProductColorAttribute whereId($value)
 * @method static Builder|ProductColorAttribute whereName($value)
 * @mixin Eloquent
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static ProductColorAttributeFactory factory(...$parameters)
 * @method static Builder|ProductColorAttribute whereCreatedAt($value)
 * @method static Builder|ProductColorAttribute whereUpdatedAt($value)
 * @property-read Collection|ShoppingCartEntry[] $shoppingCartEntries
 * @property-read int|null $shopping_cart_entries_count
 * @property-read mixed $type
 * @property-read \App\Contracts\OrderProductAttribute $order
 */
class ProductColorAttribute extends Model implements ProductAttributeToOrder
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public function products() {
        return $this->morphToMany(Product::class, 'product_attribute');
    }

    public function shoppingCartEntries()
    {
        return $this->hasMany(ShoppingCartEntry::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::COLOR;
    }

    public function getOrderEquivalent(array $attributes = []): OrderProductAttribute
    {
        return $this->findOrderEquivalent() ??
        OrderColorAttribute::create([
            'name' => $this->name,
            'color' => $this->color,
        ]);
    }

    public function findOrderEquivalent(): OrderProductAttribute
    {
        return OrderColorAttribute::where('name', $this->name)
            ->where('color', $this->color)->first();
    }

    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'color' => $this->color,
        ];
    }
}
