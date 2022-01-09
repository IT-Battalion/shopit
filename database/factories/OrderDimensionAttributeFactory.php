<?php

namespace Database\Factories;

use App\Types\Meter;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDimensionAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \App\Exceptions\InvalidUnitException
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
