<?php

namespace Database\Factories\Brands;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brands\BRAN01BrandsSection;

class BRAN01BrandsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BRAN01BrandsSection::class;

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
            'subtitle_section' => $this->faker->text(10),
            'description_section' => $this->faker->text(500),
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/port01_path_image_right.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'active_banner' => 1,
            //Content
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'description_content' => $this->faker->text(500),
            'active_content' => 1,
        ];
    }
}
