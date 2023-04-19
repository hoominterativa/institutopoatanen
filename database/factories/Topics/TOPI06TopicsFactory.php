<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI06Topics;

class TOPI06TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI06Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(400),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'path_image_desktop' => 'uploads/tmp/image-box-white.jpg',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#FFFFFF',
            'title_button' => $this->faker->text(10),
            'link_button' => 'www.lorempixel.com',
            'target_link_button' => '_blank',
            'path_image_icon_button' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
