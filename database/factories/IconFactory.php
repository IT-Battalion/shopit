<?php

namespace Database\Factories;

use App\Models\Icon;
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
        return [
            'name' => 'Portrait deiner Mutter',
            'artist' => 'Deine Mutter',
            'provider' => 'The Noun Project',
            'license' => 'CC BY 3.0',
            'mimetype' => 'image/png',
        ];
    }
}
