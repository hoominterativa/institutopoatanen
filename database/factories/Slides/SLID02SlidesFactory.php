<?php

namespace Database\Factories\Slides;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slides\SLID02Slides;

class SLID02SlidesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SLID02Slides::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Desktop',
            'path_image_icon' => 'uploads/temp/favicon.png',
            'path_image_background' => 'uploads/tmp/bg-slide.jpg',
            'link_button' => 'https://www.lipsum.com/',
            'target_link_button' => '_blank',
            'active' => 1,

            'title_mobile' => 'Mobile',
            'path_image_icon_mobile' => 'uploads/temp/favicon.png',
            'path_image_background_mobile' => 'uploads/tmp/bg-slid-mobile.jpg',
            'link_button_mobile' => 'https://www.lipsum.com/',
            'target_link_button_mobile' => '_blank',
            'active_mobile' => 1,
        ];
    }
}
