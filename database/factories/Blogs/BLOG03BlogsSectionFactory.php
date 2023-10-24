<?php

namespace Database\Factories\Blogs;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blogs\BLOG03BlogsSection;

class BLOG03BlogsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BLOG03BlogsSection::class;

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
            'description_section' => $this->faker->text(250),
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/temp/image_temporary.png',
            'path_image_mobile_banner' => 'uploads/temp/image_temporary.png',
            'background_color_banner' => '#FFFFFF',
            'active_banner' => 1,
        ];
    }
}
