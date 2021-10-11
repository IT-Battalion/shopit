<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(1, 300),
            'tax' => $this->faker->numberBetween(0, 100),
            'available' => $this->faker->numberBetween(0, 1000),
            /*'thumbnail' => ProductImage::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory()*/
        ];
    }
}
