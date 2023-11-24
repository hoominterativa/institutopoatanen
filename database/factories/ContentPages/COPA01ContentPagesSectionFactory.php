<?php

namespace Database\Factories\ContentPages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContentPages\COPA01ContentPagesSection;

class COPA01ContentPagesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA01ContentPagesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Banner
            'title' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/gall01_image1.png',
            'path_image_mobile' => 'uploads/tmp/bg-boxitem-light.png',
            'background_color' => '#FFFFFF',
            'active_banner' => 1,
            //Section
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(12),
            'description_section' => $this->faker->text(400),
            'active_section' => 1
        ];
    }
}
