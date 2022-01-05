<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\IconFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Icon
 *
 * @property int $id
 * @property string $original_id
 * @property string $name
 * @property string $artist
 * @property string $provider
 * @property int $license
 * @property string $mimetype
 * @property string $path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProductCategory $product_categories
 * @method static IconFactory factory(...$parameters)
 * @method static Builder|Icon newModelQuery()
 * @method static Builder|Icon newQuery()
 * @method static Builder|Icon query()
 * @method static Builder|Icon whereArtist($value)
 * @method static Builder|Icon whereCreatedAt($value)
 * @method static Builder|Icon whereId($value)
 * @method static Builder|Icon whereLicense($value)
 * @method static Builder|Icon whereMimetype($value)
 * @method static Builder|Icon whereName($value)
 * @method static Builder|Icon whereOriginalId($value)
 * @method static Builder|Icon wherePath($value)
 * @method static Builder|Icon whereProvider($value)
 * @method static Builder|Icon whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $product_categories_count
 */
class Icon extends Model
{
    use HasFactory;

    protected $table = 'icons';

    protected $fillable = [
        'original_id',
        'name',
        'artist',
        'provider',
        'license',
        'mimetype',
        'path',
    ];

    public function product_categories(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'icon_id');
    }
}
