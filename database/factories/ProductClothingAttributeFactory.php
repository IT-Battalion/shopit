<?php

namespace Database\Factories;

use App\Types\ClothingSize;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductClothingAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'size' => ClothingSize::getRandomCase(),
        ];
    }
}
