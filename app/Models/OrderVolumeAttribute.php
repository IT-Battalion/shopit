<?php

namespace App\Models;

use App\Contracts\OrderProductAttribute;
use App\Types\AttributeType;
use App\Types\Liter;
use Database\Factories\OrderVolumeAttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderVolumeAttribute
 *
 * @property-read Collection|OrderProduct[] $products
 * @property-read int|null $products_count
 * @method static Builder|OrderVolumeAttribute newModelQuery()
 * @method static Builder|OrderVolumeAttribute newQuery()
 * @method static Builder|OrderVolumeAttribute query()
 * @mixin Eloquent
 * @property int $id
 * @property Liter $volume
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OrderVolumeAttribute whereCreatedAt($value)
 * @method static Builder|OrderVolumeAttribute whereId($value)
 * @method static Builder|OrderVolumeAttribute whereUpdatedAt($value)
 * @method static Builder|OrderVolumeAttribute whereVolume($value)
 * @method static OrderVolumeAttributeFactory factory(...$parameters)
 * @property-read mixed $type
 */
class OrderVolumeAttribute extends Model implements OrderProductAttribute
{
    use HasFactory;

    protected $fillable = [
        'volume',
    ];

    protected $casts = [
        'volume' => Liter::class,
    ];

    public function products() {
        return $this->hasMany(OrderProduct::class);
    }

    public function getTypeAttribute(): AttributeType
    {
        return AttributeType::VOLUME;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'volume' => $this->volume,
        ];
    }
}
