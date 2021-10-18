<?php

namespace Database\Factories;

use App\Models\AttributeType;
use App\Models\OrderProduct;
use App\Models\OrderProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderProductAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(AttributeType::getValues()),
            'values_chosen' => function (array $attributes) {
                return self::available_values($attributes);
            },
            'order_product_id' => OrderProduct::all()
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
