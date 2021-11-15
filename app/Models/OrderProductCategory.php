<?php

namespace App\Models;

use Database\Factories\OrderProductCategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderProductCategory
 *
 * @property int $id
 * @property string $name
 * @property int $icon_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Icon|null $icon
 * @property-read Collection|OrderProduct[] $products
 * @property-read int|null $products_count
 * @method static OrderProductCategoryFactory factory(...$parameters)
 * @method static Builder|OrderProductCategory newModelQuery()
 * @method static Builder|OrderProductCategory newQuery()
 * @method static Builder|OrderProductCategory query()
 * @method static Builder|OrderProductCategory whereCreatedAt($value)
 * @method static Builder|OrderProductCategory whereIconId($value)
 * @method static Builder|OrderProductCategory whereId($value)
 * @method static Builder|OrderProductCategory whereName($value)
 * @method static Builder|OrderProductCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OrderProductCategory extends Model
{
    use HasFactory;

    protected $table = 'order_product_categories';

    protected $fillable = [
        'name',
        'icon_id',
    ];

    protected $casts = [];

    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function icon(): HasOne
    {
        return $this->hasOne(Icon::class);
    }
}
