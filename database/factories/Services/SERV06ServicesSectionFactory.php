<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV06ServicesSection;

class SERV06ServicesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV06ServicesSection::class;

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
            'description' => $this->faker->text(400),
            'path_image' => 'uploads/tmp/image-pmg.png',
            'path_image_desktop' => 'uploads/tmp/thumbnail.png',
            'path_image_mobile' => 'uploads/tmp/secaobox.png',
            'background_color' => '#FFFFFF',
            'active' => 1,
        ];
    }
}
