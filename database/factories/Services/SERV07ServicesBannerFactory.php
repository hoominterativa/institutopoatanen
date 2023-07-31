<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV07ServicesBanner;

class SERV07ServicesBannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV07ServicesBanner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/inner-image.jpg',
            'path_image_mobile' => 'uploads/tmp/bg-slid-mobile.jpg',
            'active' => 1,
        ];
    }
}
