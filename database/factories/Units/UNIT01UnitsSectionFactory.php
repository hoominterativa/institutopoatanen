<?php

namespace Database\Factories\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Units\UNIT01UnitsSection;

class UNIT01UnitsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT01UnitsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(10),
            'active_section' => 1,
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/gall01_image1.png',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#fff',
            'active_banner' => 1,
        ];
    }
}
