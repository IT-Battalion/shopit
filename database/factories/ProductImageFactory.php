<?php

namespace Database\Factories;

use App\Models\ProductImage;
use App\Models\User;
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
        $user = User::factory();
        return [
            'path' => $this->faker->filePath(),
            'type' => 'IMG_JPG',
            'created_by' => $user,
            'updated_by' => $user,
        ];
    }
}
