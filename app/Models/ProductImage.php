<?php

namespace App\Models;

use App\Traits\TrackInteractionUsers;
use App\Traits\UuidKey;
use App\Traits\UuidKeyAndTrackInteractionUsers;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use UuidKeyAndTrackInteractionUsers;

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

    public function created_by()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'updated_by');
    }
}
