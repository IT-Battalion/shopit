<?php

namespace Database\Factories;

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
        return [
            'path' => $this->faker->filePath(),
            'type' => 'IMG_JPG',
            /*'product_id' => Product::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory()*/
        ];
    }
}
