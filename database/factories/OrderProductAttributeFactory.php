<?php

namespace Database\Factories;

use App\Enums\AttributeType;
use App\Models\OrderProduct;
use App\Models\OrderProductAttribute;
use App\Models\ProductAttribute;
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
            'order_product_id' => OrderProduct::inRandomOrder()
                ->first()
                ->id,
        ];
    }

    private function available_values(array $attributes) {
        return ProductAttribute::factory()->available_values($attributes);
    }
}
