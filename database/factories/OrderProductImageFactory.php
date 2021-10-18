<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\OrderProduct;
use App\Models\OrderProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderProductImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $product = OrderProduct::all()
            ->random()
            ->id;

        $admin = Admin::all()
            ->random()
            ->id;

        $image = $this->faker->image();

        return [
            'path' => $image,
            'type' => 'image/png',
            'order_product_id' => $product,
            'created_by' => $admin,
            'updated_by' => $admin,
        ];
    }
}
