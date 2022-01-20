<?php

namespace App\Types;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Meter extends Unit implements Castable
{
    protected $units = ['mm', 'cm', 'dm', 'm'];

    public function __construct(int $value, string $unit = 'mm')
    {
        parent::__construct($value, $unit);
    }
}
