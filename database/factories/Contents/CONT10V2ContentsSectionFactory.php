<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT10V2ContentsSection;

class CONT10V2ContentsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT10V2ContentsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(15),
            'path_image_desktop' => 'uploads/tmp/image-box-white.jpg',
            'path_image_mobile' => 'uploads/tmp/image-box-white.jpg',
            'background_color' => '#FFFFFF',
            'active' => 1
        ];
    }
}
