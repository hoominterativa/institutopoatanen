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
            'path_image_desktop' => "uploads/tmp/image-box.jpg",
            'link' => 'https://www.lipsum.com/',
            'target_link' => '_blank',
            'active' => 1,

            'path_image_mobile' => "uploads/tmp/image-box.jpg",
            'link_mobile' => 'https://www.lipsum.com/',
            'target_link_mobile' => '_blank',
            'active_mobile' => 1,
        ];
    }
}
