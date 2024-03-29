<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $thumbnail_id
 * @property Money $price
 * @property string $tax
 * @property int $available
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $product_category_id
 * @property-read ProductCategory $category
 * @property-read User $created_by
 * @property-read Collection|ProductImage[] $images
 * @property-read int|null $images_count
 * @property-read Collection|ProductAttribute[] $productAttributes
 * @property-read int|null $product_attributes_count
 * @property-read ProductImage|null $thumbnail
 * @property-read User $updated_by
 * @method static Builder|Product available()
 * @method static ProductFactory factory(...$parameters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product unavailable()
 * @method static Builder|Product whereAvailable($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereCreatedById($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereProductCategoryId($value)
 * @method static Builder|Product whereTax($value)
 * @method static Builder|Product whereThumbnailId($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUpdatedById($value)
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
        'thumbnail_id',
    ];

    protected $casts = [
        'price' => Money::class,
        'tax' => 'string',
    ];

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(ProductImage::class, 'thumbnail_id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function createWith(User $user): Product
    {
        $this->created_by_id = $user->id;
        $this->updated_by_id = $user->id;
        return $this;
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function updateWith(User $user): Product
    {
        $this->updated_by_id = $user->id;
        return $this;
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
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
            $model->productAttributes()->delete();
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
