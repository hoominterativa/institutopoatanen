<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU05AboutsSection;

class ABOU05AboutsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU05AboutsSection::class;

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
            'description_section' => $this->faker->text(500),
            'path_image_desktop_section' => 'uploads/tmp/box-branco.png',
            'path_image_mobile_section' => 'uploads/tmp/thumbnail.png',
            'background_color_section' => '#FFFFFF',
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/box-branco.png',
            'path_image_mobile_banner' => 'uploads/tmp/thumbnail.png',
            'background_color_banner' => '#FFFFFF',
            //Section Content
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
        ];
    }
}
