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
            "title" => $this->faker->text(10),
            "subtitle" => $this->faker->text(10),
            "text" => $this->faker->paragraph(3),
            "path_image_desktop" => "uploads/tmp/bg-section-dark-gray.jpg",
            "path_image_mobile" => "uploads/tmp/image-box-white.jpg",
            "path_image" => "uploads/tmp/image-pmg.png",
            "background_color" => '#FFFFFF',
        ];
    }
}
