<?php

namespace App\Models;

use App\Traits\UuidKeyAndTrackInteractionUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Product
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property ProductImage|null $thumbnail
 * @property float $price
 * @property int $sale
 * @property int $available
 * @property User|null $created_by
 * @property User|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $product_category_id
 * @property string $attribute_value
 * @property string $attribute_type
 * @property string $attribute_unit
 * @property-read \App\Models\ProductCategory $category
 * @property-read mixed $product
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductImage[] $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttributeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttributeUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttributeValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use UuidKeyAndTrackInteractionUsers, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'price',
        'sale',
        'available',
    ];

    protected $attributeTypeNames = [
        'clothing' => 'Kleidungsgröße',
        'weight' => 'Gewicht',
        'volume' => 'Volumen',
    ];

    public function thumbnail(): HasOne
    {
        return $this->hasOne(ProductImage::class, 'id', 'thumbnail');
    }

    public function created_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updated_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function images()
    {
        return $this->belongsToMany('App\\Models\\ProductImage');
    }

    public function category()
    {
        return $this->belongsTo('App\\Models\\ProductCategory', 'product_category_id', 'id');
    }

    public function getProductAttribute()
    {
        return $this->attribute_value .
        (( $this->attribute_type && !in_array( $this->attribute_type, [ __('clothing') ] )) ?
        $this->attribute_unit : '');
    }

    public function getProductAttributeType()
    {
        return $this->attributeTypeNames[$this->attribute_type];
    }
}
