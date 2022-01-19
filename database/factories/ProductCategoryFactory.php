<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    public const categories = ['T-Shirts', 'Hoodies', 'Shirts', 'Flaschen', 'Hosen', 'Accessoires'];

    /**
     *
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [];
    }

    public function exampleCategories(): ProductCategoryFactory
    {
        return $this->sequence(fn (Sequence $sequence) =>
                ["name" => self::categories[$sequence->index % count(self::categories)]]
            );
    }

    public function allExampleCategories(): ProductCategoryFactory {
        return self::exampleCategories()->count(count(self::categories));
    }
}
