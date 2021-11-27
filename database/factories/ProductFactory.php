<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductCategory;
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
        $admin = Admin::inRandomOrder()
            ->first()
            ->id;
        $category = ProductCategory::inRandomOrder()
            ->first()
            ->id;

        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 1, 300),
            'tax' => $this->faker->randomFloat(2, 0, 0.99),
            'available' => $this->faker->numberBetween(-1, 1000),
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
            "product_category_id" => $category,
        ];
    }
}
