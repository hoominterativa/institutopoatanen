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
            //Section
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(15),
            'description_section' => $this->faker->text(400),
            'path_image_section' => 'uploads/tmp/image-pmg.png',
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(15),
            'path_image_desktop_banner' => 'uploads/tmp/thumbnail.png',
            'path_image_mobile_banner' => 'uploads/tmp/secaobox.png',
            'active_banner' => 1,
        ];
    }
}
