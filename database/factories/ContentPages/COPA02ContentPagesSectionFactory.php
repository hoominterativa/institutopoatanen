<?php

namespace Database\Factories\ContentPages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContentPages\COPA02ContentPagesSection;

class COPA02ContentPagesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA02ContentPagesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(12),
            'path_image_desktop_banner' => 'uploads/tmp/port01_path_image_right.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#CACACA',
            'active_banner' => 1,
            //Content
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(12),
            'description_content' => $this->faker->text(500),
            'path_image_desktop_content' => 'uploads/tmp/port01_path_image_right.jpg',
            'path_image_mobile_content' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_content' => '#CACACA',
            'active_content' => 1,
            //Section topics
            'title_section_topic' => $this->faker->text(10),
            'subtitle_section_topic' => $this->faker->text(12),
            'description_section_topic' => $this->faker->text(500),
            'active_section_topic' => 1,
            //Last section
            'title_last_section' => $this->faker->text(10),
            'subtitle_last_section' => $this->faker->text(12),
            'description_last_section' => $this->faker->text(400),
            'path_image_box_last_section' => 'uploads/tmp/image-box.jpg',
            'path_image_desktop_last_section' => 'uploads/tmp/image-box-white.jpg',
            'path_image_mobile_last_section' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_last_section' => '#FFFFFF',
            'title_button_last_section' => $this->faker->text(10),
            'link_button_last_section' => $this->faker->url(),
            'target_link_button_last_section' => '_blank',
            'active_last_section' => 1,
        ];
    }
}
