<?php

namespace App\Models;

use Auth;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductImage
 *
 * @property int $id
 * @property string $path
 * @property string $type
 * @property \App\Models\User $created_by
 * @property \App\Models\User $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $product_id
 * @property-read \App\Models\Product $product
 * @method static \Database\Factories\ProductImageFactory factory(...$parameters)
 * @method static Builder|ProductImage newModelQuery()
 * @method static Builder|ProductImage newQuery()
 * @method static Builder|ProductImage query()
 * @method static Builder|ProductImage whereCreatedAt($value)
 * @method static Builder|ProductImage whereCreatedBy($value)
 * @method static Builder|ProductImage whereId($value)
 * @method static Builder|ProductImage wherePath($value)
 * @method static Builder|ProductImage whereProductId($value)
 * @method static Builder|ProductImage whereType($value)
 * @method static Builder|ProductImage whereUpdatedAt($value)
 * @method static Builder|ProductImage whereUpdatedBy($value)
 * @mixin Eloquent
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

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

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function createWith(User $user): ProductImage
    {
        $this->created_by = $user->id;
        $this->updated_by = $user->id;
        return $this;
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }

    public function updateWith(User $user): ProductImage
    {
        $this->updated_by = $user->id;
        return $this;
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id', 'id');
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
