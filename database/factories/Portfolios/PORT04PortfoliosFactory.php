<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT04Portfolios;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT04PortfoliosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT04Portfolios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            //Portfólio
            'category_id' => rand(1,5),
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->text(80),
            'path_image' => 'uploads/tmp/bg-boxitem.png',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
            'featured' => rand(0, 1),
            //Internal Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/bg-boxitem.png',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => "#FFF",
            'active_banner' => 1,
            //Internal Content
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'text_content' => $this->faker->text(900),
            'path_image_content' => 'uploads/tmp/png-slide.png',
            'active_content' => 1,
            //Internal Section
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(10),
            'description_section' => $this->faker->text(300),
            'active_section' => 1,
        ];
    }
}
