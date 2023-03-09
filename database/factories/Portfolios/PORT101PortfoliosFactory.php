<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT101Portfolios;

class PORT101PortfoliosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT101Portfolios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(12),
            'description' => $this->faker->text(200),
            'link_button' => 'https://www.lipsum.com/',
            'target_link_button' => '_self',
            'path_image_box' => 'uploads/tmp/port01_path_image_box.png',
            'path_image_desktop' => 'uploads/tmp/port01_path_image_section.png',
            'path_image_mobile' => 'uploads/tmp/slid01_path_image_desktop.png',
        ];
    }
}
