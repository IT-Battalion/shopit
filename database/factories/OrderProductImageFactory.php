<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\OrderProduct;
use App\Models\OrderProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        $admin = Admin::inRandomOrder()
            ->first()
            ->id;

        $id = $this->faker->unique()->randomNumber(5, false);
        $source = fopen(resource_path('image/bottle.png'), 'r');
        $path = "order/product/images/$id.png";
        Storage::put($path, $source);

        return [
            'path' => $path,
            'type' => 'image/png',
            'hash' => $this->faker->unique()->sha256(),
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
        ];
    }
}
