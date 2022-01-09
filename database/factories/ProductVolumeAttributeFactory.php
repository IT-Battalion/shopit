<?php

namespace Database\Factories;

use App\Exceptions\InvalidUnitException;
use App\Types\Liter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVolumeAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws InvalidUnitException
     */
    public function definition()
    {
        return [
            'volume' => new Liter($this->faker->numberBetween(1, 99999)),
        ];
    }
}
