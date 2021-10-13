<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    protected $categories = [
        'T-Shirts',
        'Jeans',
        'Shoes',
        'Shirts',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement($this->categories),
        ];
    }
}
