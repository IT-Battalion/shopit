<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Contracts\ProductAttributeToOrder;
use App\Types\AttributeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class ProductColorAttribute extends Model implements ProductAttributeToOrder
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'color_attribute');
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

    public function findOrderEquivalent(): OrderProductAttribute|null
    {
        return OrderColorAttribute::where('name', $this->name)
            ->where('color', $this->color)->first();
    }

    #[ArrayShape(['id' => "int", 'type' => "mixed", 'name' => "string", 'color' => "string"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'color' => '#' . $this->color,
        ];
    }
}
