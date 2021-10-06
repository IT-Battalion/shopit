<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * The two types of employees
     *
     * @var string[]
     */

    private const employeeTypes = ["schueler", "lehrer"];

    /**
     * The different types of classes
     *
     * @var string[]
     */

    private const classes = ["A", "B", "C", "D"];

    /**
     * All departments
     *
     * @var string[]
     */

    private const departments = ["HBG", "HEL", "HET", "HIT", "HKT", "HLB", "HMB", "HWI"];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $firstname = $this->faker->unique()->firstName();
        $lastname = $this->faker->unique()->lastName();
        $username = $firstname[0] . $lastname . ".test";
        $employeeType = Arr::random(self::employeeTypes);

        switch ($employeeType) {
            case "schueler":
                $email = "$username@student.tgm.ac.at";
                break;
            case "lehrer":
                $email = "$username@tgm.ac.at";
                break;
            default:
                $email = "$username@tgm.ac.at";
        }

        return [
            'username' => $username,
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'name' => "$firstname $lastname",
            'employeeType' => $employeeType,
            'class' => $this->generateClass(),
            'lang' => 'de-AT',
            'guid' => $this->faker->unique()->uuid(),
        ];
    }

    /**
     * Generates a random class for the generated user
     * @return string
     */

    private function generateClass(): string
    {
        $year = rand(1, 5);
        $class = Arr::random(self::classes);
        //$department = Arr::random(self::departments);
        $department = "HIT"; // The application should only be used by members of the HIT department
        return "$year$class$department";
    }
}
