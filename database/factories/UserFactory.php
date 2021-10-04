<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'email' => $this->faker->companyEmail(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'name' => $this->faker->name(),
            'employeeType' => $this->faker->jobTitle(),
        ];
    }
}
