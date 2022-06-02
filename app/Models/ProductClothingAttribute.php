<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use App\Types\ClothingSize;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class ProductClothingAttribute extends Model implements ProductAttributeToOrder
{
    use HasFactory;

    protected $fillable = [
        'size',
    ];

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
