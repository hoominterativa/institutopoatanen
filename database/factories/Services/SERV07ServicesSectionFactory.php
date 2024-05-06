<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV07ServicesSection;

class SERV07ServicesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV07ServicesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Section
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(500),
            'active' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/thumbnail.png',
            'path_image_mobile' => 'uploads/tmp/bg-boxitem-light.png',
            'active_banner' => 1,
        ];
    }
}
