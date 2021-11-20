<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderProduct;
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
        $admin = Admin::inRandomOrder()
            ->first()
            ->id;

        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 1, 300),
            'tax' => $this->faker->randomFloat(2, 0, 0.99),
            'count' => $this->faker->numberBetween(0, 100),
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
        ];
    }
}
