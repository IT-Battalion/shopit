<?php

namespace Database\Factories;

use App\Models\OrderProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class OrderProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderProductCategory::class;

    /**
     *
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'icon_id' => $this->faker->numberBetween(1, count(ProductCategoryFactory::categories)),
        ];
    }

    public function exampleCategories(): OrderProductCategoryFactory
    {
        return $this->sequence(fn (Sequence $sequence) =>
        ["name" => ProductCategoryFactory::categories[$sequence->index % count(ProductCategoryFactory::categories)]]
        );
    }

    public function allExampleCategories(): OrderProductCategoryFactory {
        return self::exampleCategories()->count(count(ProductCategoryFactory::categories));
    }
}
