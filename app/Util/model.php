<?php

use Illuminate\Database\Eloquent\Model;

function getModelId(Model|int|null $model)
{
    return is_int($model) ? $model :
        $model?->id;
}
