<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV05ServicesSection;

class SERV05ServicesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV05ServicesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Home
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(400),
            'active' => 1,

            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/thumbnail.png',
            'path_image_mobile_banner' => 'uploads/tmp/image-box.jpg',
            'active_banner' => 1,

            //About
            'title_about' => $this->faker->text(10),
            'subtitle_about' => $this->faker->text(10),
            'description_about' => $this->faker->text(400),
            'active_about' => 1,

        ];
    }
}
