<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\CouponCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CouponCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CouponCode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $admin = Admin::inRandomOrder()
            ->first()
            ->id;

        return [
            'discount' => $this->faker->randomFloat(2, 0, 0.99),
            'enabled' => true,
            'enabled_until' => $this->faker->dateTimeThisMonth,
            'code' => Str::random(32),
            'created_by_id' => $admin,
            'updated_by_id' => $admin,
        ];
    }
}
