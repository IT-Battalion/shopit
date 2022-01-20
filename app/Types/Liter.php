<?php

namespace App\Types;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Liter extends Unit implements Castable
{
    protected $units = [
        'ml',
        'cl',
        'dl',
        'l',
    ];

    public function __construct(int $value, string $unit = 'ml')
    {
        parent::__construct($value, $unit);
    }
}
