<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT10ContentsSection;

class CONT10ContentsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT10ContentsSection::class;

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
            'path_image' => 'uploads/tmp/image-box-white.jpg',
            'path_image' => 'uploads/tmp/bg-slid-mobile.jpg',
            'background_color' => '#FFFFFF',
            'active' => 1
        ];
    }
}
