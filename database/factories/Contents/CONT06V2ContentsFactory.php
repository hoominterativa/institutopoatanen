<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT06V2Contents;

class CONT06V2ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT06V2Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(200),
            'link_video' => 'https://www.youtube.com/embed/NSa4DvXi1Xs',
            'title_button' => $this->faker->text(10),
            'link_button' => 'https://www.lipsum.com/',
            'target_link_button' => '_blank',
            'path_image' => 'uploads/tmp/image-box-white.jpg',
            'path_image_desktop' => 'uploads/tmp/gall01_image2.png',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#FFFFFF',
            'active' => 1
        ];
    }
}
