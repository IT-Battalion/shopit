<?php

namespace App\Types;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use JsonSerializable;
use function config;

/**
 * A class for representing a certain amount of money
 * @author pdamianik
 * @version 2022-01-01
 */

class Money implements Castable, JsonSerializable, Jsonable
{
    private string $amount;

    /**
     * @param string|mixed $amount
     */
    public function __construct(mixed $amount)
    {
        $this->amount = bcadd(self::convertToAmount($amount), '0');
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param Money|string|mixed $value
     * @return string
     */

    private static function convertToAmount(mixed $value)
    {
        if ($value instanceof Money) {
            return $value->amount;
        } else if (is_string($value)) {
            return $value;
        } else {
            return (string) $value;
        }
    }

    /**
     * @param Money|string|mixed ...$others
     * @return Money
     */

    public function add(mixed ...$others)
    {
        $amount = $this->amount;

        foreach ($others as $other) {
            $otherAmount = self::convertToAmount($other);
            $amount = bcadd($amount, $otherAmount);
        }

        return new Money($amount ?? $this->amount);
    }

    /**
     * @param Money|string|mixed ...$others
     * @return Money
     */

    public function sub(mixed ...$others)
    {
        $amount = $this->amount;

        foreach ($others as $other) {
            $otherAmount = self::convertToAmount($other);
            $amount = bcsub($amount, $otherAmount);
        }

        return new Money($amount);
    }

    /**
     * @param Money|string|mixed ...$others
     * @return Money
     */

    public function mul(mixed ...$others)
    {
        $amount = $this->amount;

        foreach ($others as $other) {
            $otherAmount = self::convertToAmount($other);

            $amount = bcmul($amount, $otherAmount);
        }

        return new Money($amount);
    }

    /**
     * @param Money|string|mixed ...$others
     * @return Money
     */

    public function div(mixed ...$others)
    {
        $amount = $this->amount;

        foreach ($others as $other) {
            $otherAmount = self::convertToAmount($other);

            $amount = bcdiv($amount, $otherAmount);
        }

        return new Money($amount);
    }

    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes
        {

            public function get($model, string $key, $value, array $attributes)
            {
                return new Money($value);
            }

            /**
             * @param $model
             * @param string $key
             * @param Money $value
             * @param array $attributes
             * @return string
             */

            public function set($model, string $key, $value, array $attributes)
            {
                return $value->getAmount();
            }
        };
    }

    public function jsonSerialize(): string
    {
        return str_replace(',00', ',-', str_replace('.', ',', bcround($this->amount, 2))) . config('shop.money.currency');
    }

    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }
}
