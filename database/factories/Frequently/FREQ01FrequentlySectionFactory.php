<?php

namespace Database\Factories\Frequently;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Frequently\FREQ01FrequentlySection;

class FREQ01FrequentlySectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FREQ01FrequentlySection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/image-box-white.jpg',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#fff',
            'active' => 1,
        ];
    }
}
