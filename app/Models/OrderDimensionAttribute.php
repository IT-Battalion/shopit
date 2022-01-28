<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Types\AttributeType;
use App\Types\Meter;
use Database\Factories\OrderDimensionAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\OrderDimensionAttribute
 *
 * @property-read Collection|OrderProduct[] $products
 * @property-read int|null $products_count
 * @method static Builder|OrderDimensionAttribute newModelQuery()
 * @method static Builder|OrderDimensionAttribute newQuery()
 * @method static Builder|OrderDimensionAttribute query()
 * @mixin Eloquent
 * @property int $id
 * @property Meter $width
 * @property Meter $height
 * @property Meter $depth
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OrderDimensionAttribute whereCreatedAt($value)
 * @method static Builder|OrderDimensionAttribute whereDepth($value)
 * @method static Builder|OrderDimensionAttribute whereHeight($value)
 * @method static Builder|OrderDimensionAttribute whereId($value)
 * @method static Builder|OrderDimensionAttribute whereUpdatedAt($value)
 * @method static Builder|OrderDimensionAttribute whereWidth($value)
 * @method static OrderDimensionAttributeFactory factory(...$parameters)
 * @property-read mixed $type
 */
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

    public function products() {
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
