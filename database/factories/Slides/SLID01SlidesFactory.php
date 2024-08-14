<?php

namespace Database\Factories\Slides;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slides\SLID01Slides;

class SLID01SlidesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SLID01Slides::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(13),
            'description' => $this->faker->text(150),
            'title_button' => $this->faker->text(8),
            'link_button' => 'https://www.lipsum.com/',
            'path_image_desktop' => 'uploads/tmp/bg-slide.jpg',
            'path_image' => 'uploads/tmp/png-slide.png',
            'active' => 1,
            'path_image_mobile' => 'uploads/tmp/bg-slid-mobile.jpg',
        ];
    }
}
