<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Types\AttributeType;
use App\Types\Liter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class OrderVolumeAttribute extends Model implements OrderProductAttribute
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
        return $this->hasMany(OrderProduct::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::VOLUME;
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
