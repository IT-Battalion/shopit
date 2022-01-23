<?php

namespace App\Traits;

trait GetRandomEnumCase
{
    public static function getRandomCase() {
        $cases = self::cases();
        return $cases[array_rand($cases)];
    }
}
