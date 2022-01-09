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
/*
    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes {
            public function get($model, string $key, $value, array $attributes)
            {
                return new Liter($value);
            }

            /**
             * @param $model
             * @param string $key
             * @param Liter $value
             * @param array $attributes
             * @return mixed
             *//*
            public function set($model, string $key, $value, array $attributes)
            {
                return $value->getValue();
            }
        };
    }*/
}
