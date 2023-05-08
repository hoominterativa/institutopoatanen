<?php

namespace Database\Factories\Galleries;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Galleries\GALL02GalleriesSection;

class GALL02GalleriesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GALL02GalleriesSection::class;

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
            'path_image_desktop' => 'uploads/tmp/gall01_image2.png',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#CACACA',
            'active' => 1,
        ];
    }
}
