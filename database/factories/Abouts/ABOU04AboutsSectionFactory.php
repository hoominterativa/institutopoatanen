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
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(300),
            'path_image' => 'uploads/tmp/image-pmg.png',
            'path_image_desktop' => 'uploads/tmp/port01_path_image_section.jpg',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#FFFFFF',
            'active' => 1,
        ];
    }
}
