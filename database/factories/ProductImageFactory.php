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
        $product = Product::all()
            ->random()
            ->id;

        $admin = Admin::all()
            ->random()
            ->id;

        $image = $this->faker->image();

        return [
            'path' => $image,
            'type' => 'image/png',
            'product_id' => $product,
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
        ];
    }
}
