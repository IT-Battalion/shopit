<?php

namespace Database\Factories;

use App\Models\Icon;
use App\Services\Icons\NounProjectApi\ApiIcon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        $id = $this->faker->unique()->randomNumber(5, false);
        $source = fopen(resource_path('image/test_icon.png'), 'r');
        $path = "icons/$id.png";
        Storage::put($path, $source);

        return [
            'original_id' => $id,
            'name' => 'Portrait deiner Mutter',
            'artist' => 'Deine Mutter',
            'provider' => 'the Noun Project',
            'license' => ApiIcon::LICENSE_PUBLIC_DOMAIN,
            'mimetype' => 'image/png',
            'path' => $path,
        ];
    }
}
