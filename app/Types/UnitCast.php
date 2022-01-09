<?php

namespace App\Types;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UnitCast implements CastsAttributes
{
    private string $unit;

    public function __construct(string $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new $this->unit($value);
    }

    /**
     * @inheritDoc
     * @param Unit value
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value->getValue();
    }
}
