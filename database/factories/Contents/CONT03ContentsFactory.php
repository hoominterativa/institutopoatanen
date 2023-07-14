<?php

namespace Database\Factories\Contents;

use App\Models\Contents\CONT03Contents;
use Illuminate\Database\Eloquent\Factories\Factory;

class CONT03ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT03Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(10),
            "title_button" => $this->faker->text(10),
            "subtitle" => $this->faker->text(15),
            "description" => $this->faker->text(250),
            "link" => $this->faker->url(),
            "path_image_center" => 'uploads/tmp/png-slide.png',
            "path_image_right" => 'uploads/tmp/png-slide.png',
            "path_image_background" => 'uploads/tmp/bg-section-gray.jpg',
            "active" => 1,
        ];
    }
}
