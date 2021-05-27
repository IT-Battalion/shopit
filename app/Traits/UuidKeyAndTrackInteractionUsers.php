<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait UuidKeyAndTrackInteractionUsers {
    /**
     * Updated created by and updated by fields when their
     * respective events get fired
     */

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
            if (empty($model->{$model->getKeyName()}))
            {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }

    /**
     * The UUID type doesn't automatically increment
     */

    public function getIncrementing()
    {
        return false;
    }

    /**
     * Tell the model that the key is a string
     */

    public function getKeyType()
    {
        return 'string';
    }
}
