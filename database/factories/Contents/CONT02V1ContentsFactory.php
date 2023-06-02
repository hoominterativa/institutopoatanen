<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT02V1Contents;

class CONT02V1ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT02V1Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(15),
            'description' => $this->faker->text(200),
            'link_button' => 'https://www.lipsum.com/',
            'target_link_button' => '_blank',
            'path_image_background_desktop' => 'uploads/tmp/gall01_image1.png',
            'path_image_background_mobile' => 'uploads/tmp/port01_path_image_left.jpg',
            'path_image' => 'uploads/tmp/image-pmg.png',
            'color' => '#4a81d4',
            'active' => 1
        ];
    }
}
