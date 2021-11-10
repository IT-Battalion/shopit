<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ShoppingCart
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $product
 * @property-read int|null $product_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ShoppingCartFactory factory(...$parameters)
 * @method static Builder|ShoppingCart newModelQuery()
 * @method static Builder|ShoppingCart newQuery()
 * @method static Builder|ShoppingCart query()
 * @method static Builder|ShoppingCart whereCount($value)
 * @method static Builder|ShoppingCart whereCreatedAt($value)
 * @method static Builder|ShoppingCart whereId($value)
 * @method static Builder|ShoppingCart whereProductId($value)
 * @method static Builder|ShoppingCart whereUpdatedAt($value)
 * @method static Builder|ShoppingCart whereUserId($value)
 * @mixin Eloquent
 */
class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'shopping_cart';

    protected $fillable = [
        'user_id',
        'product_id',
        'count',
    ];

    protected $casts = [
        'count' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'integer',
    ];

    public function product(): HasOneOrMany
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
