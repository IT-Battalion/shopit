<?php

namespace App\Models;

use App\Types\AttributeType;
use App\Types\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'available',
        'tax',
        'thumbnail_id',
        'order_id',
        'count',
        'created_by_id',
        'updated_by_id',
    ];

    protected $casts = [
        'price' => Money::class,
        'tax' => 'string',
    ];

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(OrderProductImage::class, 'thumbnail_id');
    }

    public function getMainThumbnailAttribute()
    {
        return $this->thumbnail ?? $this->images->first();
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(OrderProductImage::class);
    }

    public function getProductAttributesAttribute()
    {
        $attributes = collect([
            $this->orderClothingAttribute,
            $this->orderDimensionAttribute,
            $this->orderVolumeAttribute,
            $this->orderColorAttribute,
        ]);

        return $attributes
            ->filter(fn($attribute) => !is_null($attribute));
    }

    public function setProductAttributesAttribute(Collection $attributes)
    {
        foreach ($attributes as $type => $attribute) {
            switch ($type) {
                case AttributeType::CLOTHING->value:
                    $this->order_clothing_attribute_id = $attribute->id;
                    break;
                case AttributeType::DIMENSION->value:
                    $this->order_dimension_attribute_id = $attribute->id;
                    break;
                case AttributeType::VOLUME->value:
                    $this->order_volume_attribute_id = $attribute->id;
                    break;
                case AttributeType::COLOR->value:
                    $this->order_color_attribute_id = $attribute->id;
                    break;
            }
        }
    }

    public function orderClothingAttribute()
    {
        return $this->belongsTo(OrderClothingAttribute::class);
    }

    public function orderDimensionAttribute()
    {
        return $this->belongsTo(OrderDimensionAttribute::class);
    }

    public function orderVolumeAttribute()
    {
        return $this->belongsTo(OrderVolumeAttribute::class);
    }

    public function orderColorAttribute()
    {
        return $this->belongsTo(OrderColorAttribute::class);
    }
}
