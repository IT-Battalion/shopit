<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ProductImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductImage::class;

    private const PATHS = ['image/bottle.png', 'image/tshirt.jpg'];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $product = (Product::doesntHave('images')
            ->inRandomOrder()
            ->first(['id']) ??
            Product::inRandomOrder()
                ->first(['id']))->id;

        $admin = Admin::inRandomOrder()
            ->first()
            ->id;

        $id = $this->faker->unique()->randomNumber(5, false);
        $source = fopen(resource_path(collect(self::PATHS)->random()), 'r');
        $path = "product/images/$id.png";
        Storage::put($path, $source);

        return [
            'path' => $path,
            'type' => 'image/png',
            'product_id' => $product,
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
        ];
    }
}
