<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderClothingAttribute;
use App\Models\OrderColorAttribute;
use App\Models\OrderDimensionAttribute;
use App\Models\OrderProduct;
use App\Models\OrderVolumeAttribute;
use App\Types\Money;
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

        $order = Order::doesntHave('products')->inRandomOrder()->first() ?? Order::inRandomOrder()->first();

        return [
            'order_id' => $order->id,
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => new Money($this->faker->randomFloat(2, 1, 300)),
            'tax' => collect([.2, 0])->random(),
            'count' => $this->faker->numberBetween(0, 100),
            'order_clothing_attribute_id' => mt_rand(0, 1) ? OrderClothingAttribute::inRandomOrder()->first()->id : null,
            'order_dimension_attribute_id' => mt_rand(0, 1) ? OrderDimensionAttribute::inRandomOrder()->first()->id : null,
            'order_volume_attribute_id' => mt_rand(0, 1) ? OrderVolumeAttribute::inRandomOrder()->first()->id : null,
            'order_color_attribute_id' => mt_rand(0, 1) ? OrderColorAttribute::inRandomOrder()->first()->id : null,
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
        ];
    }
}
