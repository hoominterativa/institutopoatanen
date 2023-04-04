<?php

namespace Database\Factories\Slides;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slides\SLID02SlidesTopic;

class SLID02SlidesTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SLID02SlidesTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'link' => 'https://www.lipsum.com/',
            'target_link' => '_blank',
            'path_image_icon' => 'uploads/temp/favicon.png',
            'active' => 1,
        ];
    }
}
