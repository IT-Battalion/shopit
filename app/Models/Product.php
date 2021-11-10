<?php

namespace App\Models;

use Auth;
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
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \App\Models\ProductImage|null $thumbnail
 * @property float $price
 * @property float $tax
 * @property int $available
 * @property \App\Models\User $created_by
 * @property \App\Models\User $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $product_category_id
 * @property-read Collection|\App\Models\ProductAttribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Models\ProductCategory $category
 * @property-read Collection|\App\Models\ProductImage[] $images
 * @property-read int|null $images_count
 * @method static Builder|Product available()
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product unavailable()
 * @method static Builder|Product whereAvailable($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereCreatedBy($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereProductCategoryId($value)
 * @method static Builder|Product whereTax($value)
 * @method static Builder|Product whereThumbnail($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUpdatedBy($value)
 * @mixin Eloquent
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
        'price',
        'available',
        'tax',
        'product_category_id',
        'thumbnail',
    ];

    protected $casts = [
        'price' => 'float',
        'available' => 'integer',
        'tax' => 'float',
        'product_category_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'thumbnail' => 'integer',
    ];

    public function thumbnail(): HasOne
    {
        return $this->hasOne(ProductImage::class, 'id', 'thumbnail');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function createWith(User $user): Product
    {
        $this->created_by = $user->id;
        $this->updated_by = $user->id;
        return $this;
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }

    public function updateWith(User $user): Product
    {
        $this->updated_by = $user->id;
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

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Product $model) {
            if (!isset($model->created_by)) $model->createWith(Auth::user());
        });
        static::updating(function (Product $model) {
            if (!isset($model->updated_by)) $model->updateWith(Auth::user());
        });
        static::deleting(function (Product $model) {
            $model->images()->delete();
            $model->attributes()->delete();
        });
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('available', '>', '0')->orWhere('available', '=', '-1');
    }

    public function scopeUnavailable(Builder $query): Builder
    {
        return $query->where('available', '=', '0');
    }
}
