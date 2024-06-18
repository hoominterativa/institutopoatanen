<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT05PortfoliosSection;

class PORT05PortfoliosSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT05PortfoliosSection::class;

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
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'active_banner' => 1,
        ];
    }
}
