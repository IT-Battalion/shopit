<?php

namespace App\Services\Icons;

use App\Models\Icon;

interface IconServiceInterface
{
    /**
     * @return Icon[]
     */
    public function find(string $iconName) : array;
}
