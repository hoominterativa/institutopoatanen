<?php

namespace Database\Factories\Contents;

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
            'link' => 'https://hoom.com.br/documentacao/index.php',
            'path_image_desktop' => 'uploads/tmp/gall01_image1.png',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#FFFFFF',
            'active' => 1,

            //Section
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(50),
            'active_section' => 1,
        ];
    }
}
