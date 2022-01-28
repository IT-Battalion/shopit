<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Types\AttributeType;
use App\Types\Meter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class OrderDimensionAttribute extends Model implements OrderProductAttribute
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
        return $this->hasMany(OrderProduct::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::DIMENSION;
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
