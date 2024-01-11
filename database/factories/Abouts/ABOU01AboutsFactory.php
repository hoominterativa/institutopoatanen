<?php

namespace Database\Factories\Abouts;

use Illuminate\Support\Str;
use App\Models\Abouts\ABOU01Abouts;
use Illuminate\Database\Eloquent\Factories\Factory;

class ABOU01AboutsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU01Abouts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        $subtitle = $this->faker->text(10);
        return [
            'slug' => Str::slug($title. ' ' .$subtitle),
            "title" => $title,
            "subtitle" => $subtitle,
            "text" => $this->faker->paragraph(3),
            "path_image_desktop" => "uploads/tmp/bg-section-dark-gray.jpg",
            "path_image_mobile" => "uploads/tmp/image-box-white.jpg",
            "path_image" => "uploads/tmp/image-pmg.png",
            "background_color" => '#FFFFFF',
            "active" => 1,
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
