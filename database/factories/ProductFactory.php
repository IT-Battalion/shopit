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

    protected $namesSeen = [];

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

        $uniqueNameValidator = function($name) {
            if (in_array($name, $this->namesSeen)) {
                return false;
            }

            return Product::whereName($name)->count() === 0;
        };

        $name = $this->faker->valid($uniqueNameValidator)->word;

        $this->namesSeen[] = $name;

        return [
            'name' => $name,
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
