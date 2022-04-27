<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text_type' => $this->faker->randomElement(['agb', 'impressum']),
            'text_raw' => $this->faker->realTextBetween(400, 12000)
        ];
    }
}
