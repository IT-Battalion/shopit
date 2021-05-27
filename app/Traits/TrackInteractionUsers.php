<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait TrackInteractionUsers {
    /**
     * Updated created by and updated by fields when their
     * respective events get fired
     */

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::user();
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::user();
        });
    }
}
