<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV09ServicesSection;

class SERV09ServicesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV09ServicesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Section Home
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(250),
            'active' => 1,
            // Section Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'active_banner' => 1,
            'path_image_desktop' => 'uploads/tmp/bg-boxitem.png',
            'path_image_mobile' => 'uploads/tmp/image-box-white.jpg',
            'background_color' => '#FFFFFF',
        ];
    }
}
