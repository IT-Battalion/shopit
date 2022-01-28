<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use App\Types\Meter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

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

    public function products()
    {
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
