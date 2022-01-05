<?php

namespace Database\Factories;

use App\Enums\AttributeType;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(AttributeType::getValues()),
            'values_available' => function (array $attributes) {
                return self::available_values($attributes);
            },
            'product_id' => Product::inRandomOrder()
                ->first()
                ->id,
        ];
    }

    public function available_values(array $attributes) {
        return match ($attributes['type']) {
            AttributeType::CLOTHING_SIZE => json_encode(['XS', 'S', 'M', 'L', 'XL']),
            AttributeType::DIMENSIONS => json_encode([
                [
                    'width' => $this->faker->randomNumber(3) . 'cm',
                    'height' => $this->faker->randomNumber(3) . 'cm',
                    'depth' => $this->faker->randomNumber(3) . 'cm',
                ],
                [
                    'width' => $this->faker->randomNumber(3) . 'cm',
                    'height' => $this->faker->randomNumber(3) . 'cm',
                    'depth' => $this->faker->randomNumber(3) . 'cm',
                ],
                [
                    'width' => $this->faker->randomNumber(3) . 'cm',
                    'height' => $this->faker->randomNumber(3) . 'cm',
                    'depth' => $this->faker->randomNumber(3) . 'cm',
                ]
            ]),
            AttributeType::VOLUME => json_encode([
                '0.5l', '0.6l', '1l',
            ]),
            AttributeType::COLOR => json_encode([
                [
                    'name' => 'Blau',
                    'color' => '#0000ff',
                ],
                [
                    'name' => 'Rot',
                    'color' => '#ff0000',
                ],
                [
                    'name' => 'Grün',
                    'color' => '#00ff00',
                ]
            ]),
            default => '',
        };
    }
}
