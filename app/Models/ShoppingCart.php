<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ShoppingCart
 *
 * @property int $user_id
 * @property int $product_id
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ShoppingCart newModelQuery()
 * @method static Builder|ShoppingCart newQuery()
 * @method static Builder|ShoppingCart query()
 * @method static Builder|ShoppingCart whereCount($value)
 * @method static Builder|ShoppingCart whereCreatedAt($value)
 * @method static Builder|ShoppingCart whereProductId($value)
 * @method static Builder|ShoppingCart whereUpdatedAt($value)
 * @method static Builder|ShoppingCart whereUserId($value)
 * @mixin Eloquent
 */
class ShoppingCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'count',
    ];

    protected $casts = [
        'count' => 'integer'
    ];

    protected $table = 'shopping_cart';


}
