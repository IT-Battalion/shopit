<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Types\AttributeType;
use App\Types\ClothingSize;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class OrderClothingAttribute extends Model implements OrderProductAttribute
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
        return $this->hasMany(OrderProduct::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::CLOTHING;
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
