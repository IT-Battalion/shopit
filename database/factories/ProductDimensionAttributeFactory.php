<?php

namespace Database\Factories;

use App\Exceptions\InvalidUnitException;
use App\Types\Meter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDimensionAttributeFactory extends Factory
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
            'width' => new Meter($this->faker->numberBetween(1, 99999)),
            'height' => new Meter($this->faker->numberBetween(1, 99999)),
            'depth' => new Meter($this->faker->numberBetween(1, 99999)),
        ];
    }
}
