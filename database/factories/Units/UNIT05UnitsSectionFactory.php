<?php

namespace Database\Factories\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Units\UNIT05UnitsSection;

class UNIT05UnitsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT05UnitsSection::class;

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
            'subtitle_section' => $this->faker->text(12),
            'description_section' => $this->faker->paragraphs(3, true),
            'path_image_desktop_section' => 'uploads/tmp/bg-section-dark-gray.jpg',
            'path_image_mobile_section' => 'uploads/tmp/image-box-white.jpg',
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(12),
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/image-box-white.jpg',
            'active_banner' => 1,
        ];
    }
}
