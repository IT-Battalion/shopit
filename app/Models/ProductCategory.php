<?php

namespace App\Models;

use Database\Factories\ProductCategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductCategory
 *
 * @property int $id
 * @property string $name
 * @property int $icon_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Icon|null $icon
 * @property-read Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static ProductCategoryFactory factory(...$parameters)
 * @method static Builder|ProductCategory newModelQuery()
 * @method static Builder|ProductCategory newQuery()
 * @method static Builder|ProductCategory query()
 * @method static Builder|ProductCategory whereCreatedAt($value)
 * @method static Builder|ProductCategory whereIconId($value)
 * @method static Builder|ProductCategory whereId($value)
 * @method static Builder|ProductCategory whereName($value)
 * @method static Builder|ProductCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'icon_id',
    ];

    protected $casts = [
      'icon_id' => 'integer',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function icon(): HasOne
    {
        return $this->hasOne(Icon::class);
    }
}
