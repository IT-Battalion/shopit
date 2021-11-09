<?php

namespace App\Models;

use Auth;
use Database\Factories\ProductImageFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductImage
 *
 * @property string $id
 * @property string $path
 * @property string $type
 * @property User|null $created_by
 * @property User|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProductImage newModelQuery()
 * @method static Builder|ProductImage newQuery()
 * @method static Builder|ProductImage query()
 * @method static Builder|ProductImage whereCreatedAt($value)
 * @method static Builder|ProductImage whereCreatedBy($value)
 * @method static Builder|ProductImage whereId($value)
 * @method static Builder|ProductImage wherePath($value)
 * @method static Builder|ProductImage whereType($value)
 * @method static Builder|ProductImage whereUpdatedAt($value)
 * @method static Builder|ProductImage whereUpdatedBy($value)
 * @mixin Eloquent
 * @property string $product_id
 * @method static ProductImageFactory factory(...$parameters)
 * @method static Builder|ProductImage whereProductId($value)
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
        'product_id',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function created_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function createWith(User $user): ProductImage
    {
        $this->created_by = $user->id;
        $this->updated_by = $user->id;
        return $this;
    }

    public function updated_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function updateWith(User $user): ProductImage
    {
        $this->updated_by = $user->id;
        return $this;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (ProductImage $model) {
            if (!isset($model->created_by)) $model->createWith(Auth::user());
        });
        static::updating(function (ProductImage $model) {
            if (!isset($model->updated_by)) $model->updateWith(Auth::user());
        });
    }
}
