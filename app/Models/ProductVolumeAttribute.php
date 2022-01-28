<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use App\Types\Liter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class ProductVolumeAttribute extends Model implements ProductAttributeToOrder
{
    use HasFactory;

    protected $fillable = [
        'volume',
    ];

    protected $casts = [
        'volume' => Liter::class,
    ];

    public function products()
    {
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

    public function findOrderEquivalent(): OrderProductAttribute|null
    {
        return OrderVolumeAttribute::whereVolume($this->volume->getValue())->first();
    }

    #[ArrayShape(['id' => "int", 'type' => "mixed", 'volume' => "\App\Types\Liter"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'volume' => $this->volume,
        ];
    }
}
