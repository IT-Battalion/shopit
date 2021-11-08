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
            'product_id' => Product::all()
                ->random()
                ->id,
        ];
    }

    private function available_values(array $attributes) {
        switch ($attributes['type']) {
            case AttributeType::CLOTHING_SIZE:
                return json_encode(['XS', 'S', 'M', 'L', 'XL']);
            case AttributeType::DIMENSIONS:
                return json_encode([
                    [
                        'width' => $this->faker->randomNumber(3) . 'cm',
                        'height' => $this->faker->randomNumber(3) . 'cm',
                        'depth' => $this->faker->randomNumber(3) . 'cm',
                    ]
                ]);
            case AttributeType::VOLUME:
                return json_encode([
                    '0.5l', '0.6l', '1l',
                ]);
            case AttributeType::COLOR:
                return json_encode([
                    'Blau:#0000ff',
                    'Rot:#ff0000',
                    'Grün:#00ff00',
                ]);
        }
        return '';
    }
}
