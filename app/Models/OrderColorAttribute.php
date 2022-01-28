<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Types\AttributeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class OrderColorAttribute extends Model implements OrderProductAttribute
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::COLOR;
    }

    #[ArrayShape(['id' => "int", 'type' => "mixed", 'name' => "string", 'color' => "string"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'color' => $this->color,
        ];
    }
}
