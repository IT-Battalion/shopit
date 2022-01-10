<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Renderable;
use App\Util\Math;

/**
 * A class for representing a certain amount of money
 * @author pdamianik
 * @version 2022-01-01
 */

class Money implements Castable, Renderable
{
    private string $amount;

    /**
     * @param string|mixed $amount
     */
    public function __construct(mixed $amount)
    {
        if ($amount instanceof Money) {
            $amount = $amount->amount;
        }

        $this->amount = bcadd((string) $amount, '0'); // the add has to be performed to get the number with the
                                                            // right amount of points after the comma. The string will be
                                                            // filled up with zeros to the required amount specified
                                                            // in the shop.php config file.
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
     * @param Money|string|mixed ...$others
     * @return Money
     */

    public function add(mixed ...$others) {
        foreach ($others as $other) {
            if ($other instanceof Money) {
                $this->amount = bcadd($this->amount, $other->amount);
            } else if (is_string($other)) {
                $this->amount = bcadd($this->amount, $other);
            } else {
                $this->amount = bcadd($this->amount, strval($other));
            }
        }

        return $this;
    }

    /**
     * @param Money|string|mixed ...$others
     * @return Money
     */

    public function sub(mixed ...$others) {
        foreach ($others as $other) {
            if ($other instanceof Money) {
                $this->amount = bcsub($this->amount, $other->amount);
            } else if (is_string($other)) {
                $this->amount = bcsub($this->amount, $other);
            } else {
                $this->amount = bcsub($this->amount, strval($other));
            }
        }

        return $this;
    }

    /**
     * @param Money|string|mixed ...$others
     * @return Money
     */

    public function mul(mixed ...$others) {
        foreach ($others as $other) {
            if ($other instanceof Money) {
                $this->amount = bcmul($this->amount, $other->amount);
            } else if (is_string($other)) {
                $this->amount = bcmul($this->amount, $other);
            } else {
                $this->amount = bcmul($this->amount, strval($other));
            }
        }

        return $this;
    }

    /**
     * @param Money|string|mixed ...$others
     * @return Money
     */

    public function div(mixed ...$others) {
        foreach ($others as $other) {
            if ($other instanceof Money) {
                $this->amount = bcdiv($this->amount, $other->amount);
            } else if (is_string($other)) {
                $this->amount = bcdiv($this->amount, $other);
            } else {
                $this->amount = bcdiv($this->amount, strval($other));
            }
        }

        return $this;
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

    public function render()
    {
        return Math::bcround($this->amount, 2) . config('shop.money.currency');
    }
}
