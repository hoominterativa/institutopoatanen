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
            "title_section" => "Titulo",
            "subtitle_section" => "Subtítulo",
            "description_section" => $this->faker->text(550),
            "title_banner" => "Titulo do banner",
            "subtitle_banner" => "SUBTITULO",
            "path_image_banner" => "uploads/tmp/bg-banner-inner.jpg",
            "title_inner_section" => "Titulo",
            "subtitle_inner_section" => "Subtitulo",
            "path_image_inner_section" => "uploads/tmp/image-pmg.png",
            "path_image_section_desktop" => "uploads/tmp/bg-section-dark-gray.jpg",
            "path_image_section_mobile" => "uploads/tmp/image-box-white.jpg",
            "text_inner_section" => $this->faker->text(250),
            "background_color" => '#FFFFFF',
        ];
    }
}
