<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU02AboutsSection;

class ABOU02AboutsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU02AboutsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Section Home
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(10),
            'description_section' => $this->faker->text(250),
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(12),
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#FFFFFF',
            'active_banner' => 1,
            //Section topics
            'title_topics' => $this->faker->text(10),
            'subtitle_topics' => $this->faker->text(12),
            'active_topic' => 1,
            //Content
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'description_content' => $this->faker->text(200),
            'title_button_content' => $this->faker->text(12),
            'link_button_content' => $this->faker->url(),
            'target_link_button_content' => '_blank',
            'path_image_content' => 'uploads/tmp/image-pmg.png',
            'path_image_desktop_content' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_content' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_content' => '#FFFFFF',
            'active_content' => 1,
        ];
    }
}
