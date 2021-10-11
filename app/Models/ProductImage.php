<?php

namespace App\Models;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\ProductImage
 *
 * @property string $id
 * @property string $path
 * @property string $type
 * @property User|null $created_by
 * @property User|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereUpdatedBy($value)
 * @mixin \Eloquent
 * @property string $product_id
 * @method static \Database\Factories\ProductImageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereProductId($value)
 */
class ProductImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'type',
        'thumbnail',
    ];

    public function created_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function createWith(User $user): ProductImage
    {
        $this->created_by = $user;
        $this->updated_by = $user;
        return $this;
    }

    public function updated_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function updateWith(User $user): ProductImage
    {
        $this->updated_by = $user;
        return $this;
    }
}
