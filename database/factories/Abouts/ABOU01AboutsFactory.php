<?php

namespace Database\Factories\Abouts;

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
        return [
            "title_banner" => "Titulo do banner",
            "subtitle_banner" => "SUBTITULO",
            "path_image_banner" => "uploads/tmp/bg-banner-inner.jpg",
            "title" => "Titulo",
            "subtitle" => "Subtitulo",
            "text" => $this->faker->paragraph(3),
            "title_inner_section" => "Titulo",
            "subtitle_inner_section" => "Subtitulo",
            "path_image_inner_section" => "uploads/tmp/image-pmg.png",
            "text_inner_section" => $this->faker->text(250),
        ];
    }
}
