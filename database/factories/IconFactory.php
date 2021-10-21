<?php

namespace Database\Factories;

use App\Models\Icon;
use App\Services\Icons\Api\ApiIcon;
use Illuminate\Database\Eloquent\Factories\Factory;

class IconFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Icon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $icon_image = $this->faker->image(null, 24, 24);

        return [
            'original_id' => $this->faker->unique()->randomNumber(5, false),
            'name' => 'Portrait deiner Mutter',
            'artist' => 'Deine Mutter',
            'provider' => 'the Noun Project',
            'license' => ApiIcon::LICENSE_CC_BY_3_0,
            'mimetype' => 'image/png',
            'path' => $icon_image,
        ];
    }
}
