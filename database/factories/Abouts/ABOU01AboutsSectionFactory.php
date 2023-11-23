<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU01AboutsSection;

class ABOU01AboutsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU01AboutsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Section Home
            "title_section" => $this->faker->text(10),
            "subtitle_section" => $this->faker->text(10),
            "description_section" => $this->faker->text(550),
            "path_image_section_desktop" => "uploads/tmp/bg-section-dark-gray.jpg",
            "path_image_section_mobile" => "uploads/tmp/image-box-white.jpg",
            "background_color_section" => '#FFFFFF',
            'active_section' => 1,
            // Banner
            "title_banner" => $this->faker->text(10),
            "subtitle_banner" => $this->faker->text(10),
            "path_image_banner_desktop" => "uploads/tmp/bg-section-dark-gray.jpg",
            "path_image_banner_mobile" => "uploads/tmp/image-box-white.jpg",
            "background_color_banner" => '#FFFFFF',
            'active_banner' => 1,
            // Section Topic
            "path_image_topic_desktop" => "uploads/tmp/bg-section-dark-gray.jpg",
            "path_image_topic_mobile" => "uploads/tmp/image-box-white.jpg",
            "background_color_topic" => '#FFFFFF',
            //Content
            "title_content" => $this->faker->text(10),
            "subtitle_content" => $this->faker->text(10),
            "text_content" => $this->faker->text(700),
            "title_button_content" => $this->faker->text(6),
            "link_button_content" => $this->faker->url(),
            "target_link_button_content" => ('_blank'),
            "path_image_content" => "uploads/tmp/image-pmg.png",
            "path_image_content_desktop" => "uploads/tmp/bg-section-dark-gray.jpg",
            "path_image_content_mobile" => "uploads/tmp/image-box-white.jpg",
            "background_color_content" => '#FFFFFF',
            'active_content' => 1,
        ];
    }
}
