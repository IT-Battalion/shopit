<?php

namespace Database\Factories;

use App\Models\HighlightedProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class HighlightedProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HighlightedProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::all()->random()->id
        ];
    }
}
