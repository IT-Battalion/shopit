<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Types\AttributeType;
use Database\Factories\OrderColorAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderColorAttribute
 *
 * @property-read Collection|OrderProduct[] $products
 * @property-read int|null $products_count
 * @method static Builder|OrderColorAttribute newModelQuery()
 * @method static Builder|OrderColorAttribute newQuery()
 * @method static Builder|OrderColorAttribute query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OrderColorAttribute whereColor($value)
 * @method static Builder|OrderColorAttribute whereCreatedAt($value)
 * @method static Builder|OrderColorAttribute whereId($value)
 * @method static Builder|OrderColorAttribute whereName($value)
 * @method static Builder|OrderColorAttribute whereUpdatedAt($value)
 * @method static OrderColorAttributeFactory factory(...$parameters)
 * @property-read mixed $type
 */
class OrderColorAttribute extends Model implements OrderProductAttribute
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public function products() {
        return $this->hasMany(OrderProduct::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::COLOR;
    }

    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'color' => $this->color,
        ];
    }
}
