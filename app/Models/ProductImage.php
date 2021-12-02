<?php

namespace App\Models;

use App\Traits\TrackInteractionUsers;
use App\Traits\UuidKey;
use App\Traits\UuidKeyAndTrackInteractionUsers;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function created_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updated_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
