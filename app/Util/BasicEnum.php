<?php

namespace App\Util;

use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;

abstract class BasicEnum
{
    private static $constCacheArray = NULL;

    /**
     * @throws ReflectionException
     */
    public static function isValidName($name, $strict = false): bool
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    /**
     * @return ReflectionClassConstant[]
     * @throws ReflectionException
     */
    private static function getConstants(): array
    {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    /**
     * @return array
     */
    public static function getValues(): array
    {
        try {
            return array_values(self::getConstants());
        } catch (ReflectionException) {
            return [];
        }
    }

    /**
     * @throws ReflectionException
     */
    public static function isValidValue($value, $strict = true): bool
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}
