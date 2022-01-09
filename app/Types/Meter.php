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
    }/*

    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes {
            /**
             * @param $model
             * @param string $key
             * @param int $value
             * @param array $attributes
             * @return void
             *//*

            public function get($model, string $key, $value, array $attributes)
            {
                new Meter($value);
            }

            /**
             * @param $model
             * @param string $key
             * @param Meter $value
             * @param array $attributes
             * @return int
             *//*

            public function set($model, string $key, $value, array $attributes)
            {
                return $value->getValue();
            }
        };
    }*/
}
