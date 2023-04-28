<?php

namespace Database\Factories\Products;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products\PROD02ProductsBanner;

class PROD02ProductsBannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD02ProductsBanner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/temp/image_temporary.png',
            'path_image_mobile' => 'uploads/temp/image_temporary.png',
            'background_color' => '#FFFFFF',
            'active' => 1,
        ];
    }
}
