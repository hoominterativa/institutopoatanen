<?php

namespace Database\Factories\Products;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products\PROD05ProductsSection;

class PROD05ProductsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD05ProductsSection::class;

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
            'description' => $this->faker->text(180),
            "path_image_banner" => 'uploads/tmp/bg-banner-inner.jpg',
            "path_image_banner_mobile" => 'uploads/tmp/bg-slid-mobile.jpg',
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'active' => 1,
        ];
    }
}
