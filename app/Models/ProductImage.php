<?php

namespace App\Models;

use Auth;
use Database\Factories\ProductImageFactory;
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
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $product_id
 * @property-read User $created_by
 * @property-read Product $product
 * @property-read User $updated_by
 * @method static ProductImageFactory factory(...$parameters)
 * @method static Builder|ProductImage newModelQuery()
 * @method static Builder|ProductImage newQuery()
 * @method static Builder|ProductImage query()
 * @method static Builder|ProductImage whereCreatedAt($value)
 * @method static Builder|ProductImage whereCreatedById($value)
 * @method static Builder|ProductImage whereId($value)
 * @method static Builder|ProductImage wherePath($value)
 * @method static Builder|ProductImage whereProductId($value)
 * @method static Builder|ProductImage whereType($value)
 * @method static Builder|ProductImage whereUpdatedAt($value)
 * @method static Builder|ProductImage whereUpdatedById($value)
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

    protected $casts = [];

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function createWith(User $user): ProductImage
    {
        $this->created_by_id = $user->id;
        $this->updated_by_id = $user->id;
        return $this;
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function updateWith(User $user): ProductImage
    {
        $this->updated_by_id = $user->id;
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
