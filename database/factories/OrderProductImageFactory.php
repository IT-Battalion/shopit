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
        $product = OrderProduct::inRandomOrder()
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
            'order_product_id' => $product,
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
        ];
    }
}
