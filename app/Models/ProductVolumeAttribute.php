<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use App\Types\Liter;
use Database\Factories\ProductVolumeAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\VolumeProductAttribute
 *
 * @property int $id
 * @property int $volume
 * @method static Builder|ProductVolumeAttribute newModelQuery()
 * @method static Builder|ProductVolumeAttribute newQuery()
 * @method static Builder|ProductVolumeAttribute query()
 * @method static Builder|ProductVolumeAttribute whereId($value)
 * @method static Builder|ProductVolumeAttribute whereVolume($value)
 * @mixin Eloquent
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static ProductVolumeAttributeFactory factory(...$parameters)
 * @method static Builder|ProductVolumeAttribute whereCreatedAt($value)
 * @method static Builder|ProductVolumeAttribute whereUpdatedAt($value)
 * @property-read Collection|ShoppingCartEntry[] $shoppingCartEntries
 * @property-read int|null $shopping_cart_entries_count
 * @property-read mixed $type
 * @property-read OrderProductAttribute $order
 */
class ProductVolumeAttribute extends Model implements ProductAttributeToOrder
{
    use HasFactory;

    protected $fillable = [
        'volume',
    ];

    protected $casts = [
        'volume' => Liter::class,
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'volume_attribute');
    }

    public function shoppingCartEntries()
    {
        return $this->hasMany(ShoppingCartEntry::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::VOLUME;
    }

    public function getOrderEquivalent(array $attributes = []): OrderProductAttribute
    {
        return $this->findOrderEquivalent() ??
            OrderVolumeAttribute::create([
                'volume' => $this->volume,
            ]);
    }

    public function findOrderEquivalent(): OrderProductAttribute
    {
        return OrderVolumeAttribute::whereVolume($this->volume);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'volume' => $this->volume,
        ];
    }
}
