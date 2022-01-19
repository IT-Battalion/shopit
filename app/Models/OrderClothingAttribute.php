<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Types\AttributeType;
use App\Types\ClothingSize;
use Database\Factories\OrderClothingAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderClothingAttribute
 *
 * @property-read Collection|OrderProduct[] $products
 * @property-read int|null $products_count
 * @method static Builder|OrderClothingAttribute newModelQuery()
 * @method static Builder|OrderClothingAttribute newQuery()
 * @method static Builder|OrderClothingAttribute query()
 * @mixin Eloquent
 * @property int $id
 * @property ClothingSize $size
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OrderClothingAttribute whereCreatedAt($value)
 * @method static Builder|OrderClothingAttribute whereId($value)
 * @method static Builder|OrderClothingAttribute whereSize($value)
 * @method static Builder|OrderClothingAttribute whereUpdatedAt($value)
 * @method static OrderClothingAttributeFactory factory(...$parameters)
 * @property-read mixed $type
 */
class OrderClothingAttribute extends Model implements OrderProductAttribute
{
    use HasFactory;

    protected $casts = [
        'size' => ClothingSize::class,
    ];

    public function products() {
        return $this->hasMany(OrderProduct::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::CLOTHING;
    }

    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'size' => $this->size,
        ];
    }
}
