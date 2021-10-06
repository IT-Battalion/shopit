<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
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
    public function definition()
    {
        $user = User::factory();
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'thumbnail' => ProductImage::factory(),
            'price' => $this->faker->numberBetween(1, 300),
            'sale' => $this->faker->numberBetween(0, 100),
            'available' => $this->faker->numberBetween(0, 1000),
            'created_by' => $user,
            'updated_by' => $user
        ];
    }
}
