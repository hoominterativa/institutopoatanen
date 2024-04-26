<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV08ServicesSection;

class SERV08ServicesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV08ServicesSection::class;

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
            //Section Content
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'description_content' => $this->faker->text(250),
            'active_content' => 1,
        ];
    }
}
