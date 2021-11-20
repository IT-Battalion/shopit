<?php

namespace Database\Factories;

use App\Models\Icon;
use App\Services\Icons\NounProjectApi\ApiIcon;
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
        $source = fopen(resource_path('image/test_icon.png'), 'r');
        $destination = tmpfile();
        stream_copy_to_stream($source, $destination);
        $path = stream_get_meta_data($destination)['uri'];

        return [
            'original_id' => $this->faker->unique()->randomNumber(5, false),
            'name' => 'Portrait deiner Mutter',
            'artist' => 'Deine Mutter',
            'provider' => 'the Noun Project',
            'license' => ApiIcon::LICENSE_CC_BY_3_0,
            'mimetype' => 'image/png',
            'path' => $path,
        ];
    }
}
