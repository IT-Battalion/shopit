<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidKey {
    /**
     * Initialize the key with a random uuid
     */

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()}))
            {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * The UUID type doesn't automatically increment
     */

    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Tell the model that the key is a string
     */

    public function getKeyType(): string
    {
        return 'string';
    }
}
