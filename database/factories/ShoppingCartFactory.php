<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShoppingCartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShoppingCart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'product_id' => Product::all()->random()->id,
            'count' => $this->faker->numberBetween(1, 100)
        ];
    }
}
