<?php

namespace Database\Factories\Teams;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teams\TEAM01TeamsBanner;

class TEAM01TeamsBannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TEAM01TeamsBanner::class;

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
            'path_image_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile' => 'uploads/tmp/gall01_image2.png',
            'active' => 1,
        ];
    }
}
