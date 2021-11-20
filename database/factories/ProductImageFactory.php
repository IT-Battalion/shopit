<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $product = Product::inRandomOrder()
            ->first()
            ->id;

        $admin = Admin::inRandomOrder()
            ->first()
            ->id;

        $source = fopen(resource_path('image/bottle.png'), 'r');
        $destination = tmpfile();
        stream_copy_to_stream($source, $destination);
        $path = stream_get_meta_data($destination)['uri'];

        return [
            'path' => $path,
            'type' => 'image/png',
            'product_id' => $product,
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
        ];
    }
}
