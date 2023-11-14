<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT04PortfoliosSection;

class PORT04PortfoliosSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT04PortfoliosSection::class;

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
            'subtitle_section' => $this->faker->text(10),
            'text_section' => $this->faker->text(400),
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/retangle.png',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#FFFFFF',
            'active_banner' => 1,
            //Content
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'text_content' => $this->faker->text(400),
            'active_content' => 1,
            //Section relationship
            'title_relationship' => $this->faker->text(10),
            'subtitle_relationship' => $this->faker->text(10),
            'description_relationship' => $this->faker->text(300),
            'active_relationship' => 1,
        ];
    }
}
