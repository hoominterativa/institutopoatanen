<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV06Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV06ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV06Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(16);
        return [
            'title' => $title,
            'title_section' => $this->faker->text(16),
            'slug' => Str::slug($title),
            'subtitle' => $this->faker->text(15),
            'text' => $this->faker->text(900),
            'path_image' => 'uploads/tmp/thumbnail.png',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
