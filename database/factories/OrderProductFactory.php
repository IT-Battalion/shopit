<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $admin = Admin::all()
            ->random()
            ->id;
        $category = OrderProductCategory::all()
            ->random()
            ->id;

        return [
            'order_id' => Order::all()->random()->id,
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(1, 300),
            'tax' => $this->faker->numberBetween(0, 100),
            'available' => $this->faker->numberBetween(0, 1000),
            'count' => $this->faker->numberBetween(0, 100),
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
            "order_product_category_id" => $category,
        ];
    }
}
