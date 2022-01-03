<?php

namespace App\Util;

class Math {
    static function bcround($number, $precision = 0)
    {
        if (str_contains($number, '.')) {
            if ($number[0] != '-') return bcadd($number, '0.' . str_repeat('0', $precision) . '5', $precision);
            return bcsub($number, '0.' . str_repeat('0', $precision) . '5', $precision);
        }
        return $number;
}
}
