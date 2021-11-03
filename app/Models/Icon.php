<?php

namespace App\Models;

use Database\Factories\IconFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Icon
 *
 * @property int $id
 * @property string $name
 * @property string $artist
 * @property string $provider
 * @property string $license
 * @property string $mimetype
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Icon newModelQuery()
 * @method static Builder|Icon newQuery()
 * @method static Builder|Icon query()
 * @method static Builder|Icon whereArtist($value)
 * @method static Builder|Icon whereCreatedAt($value)
 * @method static Builder|Icon whereId($value)
 * @method static Builder|Icon whereLicense($value)
 * @method static Builder|Icon whereMimetype($value)
 * @method static Builder|Icon whereName($value)
 * @method static Builder|Icon whereProvider($value)
 * @method static Builder|Icon whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static IconFactory factory(...$parameters)
 * @property string $original_id
 * @property string $path
 * @method static Builder|Icon whereOriginalId($value)
 * @method static Builder|Icon wherePath($value)
 */
class Icon extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_id',
        'name',
        'artist',
        'provider',
        'license',
        'mimetype',
        'path',
    ];
}
