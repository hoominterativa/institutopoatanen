<?php

namespace Database\Factories\Blogs;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blogs\BLOG01BlogsSection;

class BLOG01BlogsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BLOG01BlogsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Section
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(10),
            'description_section' => $this->faker->text(500),
            //Banner
            'title_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#CACACA',

        ];
    }
}
