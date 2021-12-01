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

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $product = (Product::select('products.id')
            ->leftJoin('product_images', 'products.id', 'product_images.product_id')
            ->groupBy('products.id')
            ->havingRaw('count(`product_images`.`id`) = 0')
            ->inRandomOrder()
            ->first() ??
            Product::inRandomOrder()
                ->first())->id;

        $admin = Admin::inRandomOrder()
            ->first()
            ->id;

        $id = $this->faker->unique()->randomNumber(5, false);
        $source = fopen(resource_path('image/bottle.png'), 'r');
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
