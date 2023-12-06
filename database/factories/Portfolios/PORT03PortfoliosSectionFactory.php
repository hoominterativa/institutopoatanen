<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT03PortfoliosSection;

class PORT03PortfoliosSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT03PortfoliosSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Section home
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(10),
            'active_section' => 1,
            //Banner page
            'title_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/bg-boxitem.png',
            'path_image_mobile_banner' => 'uploads/tmp/image-box-white.jpg',
            'background_color_banner' => '#FFFFFF',
            'active_banner' => 1,
            //Content page
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'description_content' => $this->faker->text(400),
            'path_image_icon_content' => 'uploads/tmp/favicon.png',
            'active_content' => 1,

        ];
    }
}
