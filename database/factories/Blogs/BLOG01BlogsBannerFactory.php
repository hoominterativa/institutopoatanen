<?php

namespace Database\Factories\Blogs;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blogs\BLOG01BlogsBanner;

class BLOG01BlogsBannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BLOG01BlogsBanner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#CACACA',
            'active' => 1,
        ];
    }
}
