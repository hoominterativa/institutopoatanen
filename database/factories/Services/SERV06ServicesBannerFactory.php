<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV06ServicesBanner;

class SERV06ServicesBannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV06ServicesBanner::class;

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
            'path_image_desktop' => 'uploads/tmp/thumbnail.png',
            'path_image_mobile' => 'uploads/tmp/secaobox.png',
            'background_color' => '#FFFFFF',
            'active' => 1,
        ];
    }
}
