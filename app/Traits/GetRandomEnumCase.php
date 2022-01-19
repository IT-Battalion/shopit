<?php

namespace App\Traits;

trait GetRandomEnumCase
{
    public static function getRandomValue() {
        $cases = self::cases();
        return $cases[array_rand($cases)];
    }
}
