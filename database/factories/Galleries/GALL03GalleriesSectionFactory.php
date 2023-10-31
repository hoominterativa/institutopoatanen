<?php

namespace Database\Factories\Galleries;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Galleries\GALL03GalleriesSection;

class GALL03GalleriesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GALL03GalleriesSection::class;

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
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#cccccc',
            'active_banner' => 1,
            //Section Content
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'active_content' => 1,
        ];
    }
}
