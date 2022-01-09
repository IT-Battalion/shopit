<?php

namespace Database\Factories;

use App\Types\Liter;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderVolumeAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'volume' => new Liter($this->faker->numberBetween(1, 99999)),
        ];
    }
}
