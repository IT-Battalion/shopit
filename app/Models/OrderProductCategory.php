<?php

namespace App\Models;

use App\Traits\UuidKey;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderProductCategory
 *
 * @property string $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|OrderProduct[] $products
 * @property-read int|null $products_count
 * @method static Builder|OrderProductCategory newModelQuery()
 * @method static Builder|OrderProductCategory newQuery()
 * @method static Builder|OrderProductCategory query()
 * @method static Builder|OrderProductCategory whereCreatedAt($value)
 * @method static Builder|OrderProductCategory whereId($value)
 * @method static Builder|OrderProductCategory whereName($value)
 * @method static Builder|OrderProductCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OrderProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
