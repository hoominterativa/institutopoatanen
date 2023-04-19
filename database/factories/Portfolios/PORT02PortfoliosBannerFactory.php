<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT02PortfoliosBanner;

class PORT02PortfoliosBannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT02PortfoliosBanner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile' => 'uploads/tmp/image-box-white.jpg',
            'background_color' => '#EFEFEF',
            'active' => 1,
        ];
    }
}
