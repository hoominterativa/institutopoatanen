<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV04ServicesSection;

class SERV04ServicesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV04ServicesSection::class;

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
            'description_section' => $this->faker->text(150),
            'active_section' => 1,

            'title_banner' => $this->faker->text(10),
            'description_banner' => $this->faker->text(150),
            'path_image_banner_desktop' => 'uploads/tmp/image-box-white.jpg',
            'path_image_banner_mobile' => 'uploads/tmp/bg-slid-mobile.jpg',
            'active_banner' => 1,
        ];
    }
}
