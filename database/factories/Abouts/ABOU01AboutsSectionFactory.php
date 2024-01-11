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
            "title" => $this->faker->text(10),
            "subtitle" => $this->faker->text(10),
            "description" => $this->faker->text(550),
            "title_button" => $this->faker->text(10),
            "link_button" => $this->faker->url(),
            "target_link_button" => '_blank',
            "path_image_desktop" => "uploads/tmp/bg-section-dark-gray.jpg",
            "path_image_mobile" => "uploads/tmp/image-box-white.jpg",
            "background_color" => '#FFFFFF',
            'active' => 1,
        ];
    }
}
