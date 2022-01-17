<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait TracksModification
{
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function createWith(User $user)
    {
        $this->created_by_id = $user->id;
        $this->updated_by_id = $user->id;
        return $this;
    }

    public function updateWith(User $user)
    {
        $this->updated_by_id = $user->id;
        return $this;
    }

    public static function bootTracksModification()
    {
        static::creating(function ($model) {
            if (!isset($model->created_by)) $model->createWith(Auth::user());
        });
        static::updating(function ($model) {
            if (!isset($model->updated_by)) $model->updateWith(Auth::user());
        });
        static::deleting(function ($model) {
            $model->deleteRelated();
        });
    }
}
