<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT08Contents;

class CONT08ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT08Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'text' => $this->faker->text(250),
            'title_button' => $this->faker->text(6),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'background_color' => '#FFFFFF',
            'path_image' => 'uploads/tmp/png-slide.png',
            'path_image_desktop' => 'uploads/tmp/port01_path_image_right.jpg',
            'path_image_mobile' => 'uploads/tmp/secaobox.png',
        ];
    }
}
