<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU04AboutsSection;

class ABOU04AboutsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU04AboutsSection::class;

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
            'description_section' => $this->faker->text(300),
            'path_image_section' => 'uploads/tmp/image-pmg.png',
            'path_image_desktop_section' => 'uploads/tmp/port01_path_image_section.jpg',
            'path_image_mobile_section' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_section' => '#FFFFFF',
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/gall01_image2.png',
            'background_color_banner' => '#FFFFFF',
            'active_banner' => 1,
            //Section Galleries
            'title_galleries' => $this->faker->text(10),
            'title_button_galleries' => $this->faker->text(10),
            'description_galleries' => $this->faker->text(100),
            'link_button_galleries' => $this->faker->url(),
            'target_link_button_galleries' => '_blank',
            'active_galleries' => 1,
            //Section Topics
            'path_image_desktop_topics' => 'uploads/tmp/gall01_image2.png',
            'path_image_mobile_topics' => 'uploads/tmp/gall01_image1.png',
            'background_color_topics' => '#FFFFFF',
            'active_topics' => 1,
        ];
    }
}
