<?php

namespace App\Models;

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
 */
class Icon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'artist',
        'provider',
        'license',
        'mimetype',
    ];
}