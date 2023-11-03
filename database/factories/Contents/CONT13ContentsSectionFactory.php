<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT13ContentsSection;

class CONT13ContentsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT13ContentsSection::class;

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
            'path_image' => 'uploads/tmp/image-pmg.png',
            'path_image_desktop' => 'uploads/tmp/bg-boxitem-light.png',
            'path_image_mobile' => 'uploads/tmp/bg-boxitem.png',
            'background_color' => '#FFFFFF',
            'title_topic' => $this->faker->text(10),
            'description_topic' => $this->faker->text(50),
            'active' => 1,
        ];
    }
}
