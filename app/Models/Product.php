<?php

namespace App\Models;

use App\Traits\UuidKey;
use Database\Factories\ProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $product_category_id
 * @property string $attribute_value
 * @property string $attribute_type
 * @property string $attribute_unit
 * @property-read ProductCategory $category
 * @property-read mixed $product
 * @property-read Collection|ProductImage[] $images
 * @property-read int|null $images_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereAttributeType($value)
 * @method static Builder|Product whereAttributeUnit($value)
 * @method static Builder|Product whereAttributeValue($value)
 * @method static Builder|Product whereAvailable($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereCreatedBy($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereProductCategoryId($value)
 * @method static Builder|Product whereSale($value)
 * @method static Builder|Product whereThumbnail($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUpdatedBy($value)
 * @mixin Eloquent
 * @method static ProductFactory factory(...$parameters)
 * @property-read Collection|ProductAttribute[] $attributes
 * @property-read int|null $attributes_count
 * @property float $tax
 * @method static Builder|Product whereTax($value)
 */
class Product extends Model
{
    use HasFactory;

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
        'available',
    ];

    public function thumbnail(): HasOne
    {
        return $this->hasOne(ProductImage::class, 'id', 'thumbnail');
    }

    public function created_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function createWith(User $user): Product
    {
        $this->created_by = $user;
        $this->updated_by = $user;
        return $this;
    }

    public function updated_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function updateWith(User $user): Product
    {
        $this->updated_by = $user;
        return $this;
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
