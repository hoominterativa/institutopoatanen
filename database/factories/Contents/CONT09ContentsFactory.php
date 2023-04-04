<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT09Contents;

class CONT09ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT09Contents::class;

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
            'link' => 'https://www.lipsum.com/',
            'path_image_desktop' => 'uploads/tmp/image_temporary.png',
            'path_image_mobile' => 'uploads/tmp/image_temporary.png',
            'background_color' => '#FFFFFF',
            'active' => 1,
        ];
    }
}
