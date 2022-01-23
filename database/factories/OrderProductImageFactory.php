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

    private const PATHS = ['image/bottle.png', 'image/tshirt.jpg'];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $id = $this->faker->unique()->randomNumber(5, false);
        $source = fopen(resource_path(collect(self::PATHS)->random()), 'r');
        $path = "order/product/images/$id.png";
        Storage::put($path, $source);

        return [
            'path' => $path,
            'type' => 'image/png',
            'hash' => $this->faker->unique()->sha256(),
        ];
    }
}
