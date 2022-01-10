<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\ProductCategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property-read Collection|Product[] $products
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

    protected $casts = [];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function icon(): BelongsTo
    {
        return $this->belongsTo(Icon::class);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => [
                'id' => $this->icon_id,
            ],
        ];
    }
}
