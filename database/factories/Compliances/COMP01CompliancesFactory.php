<?php

namespace Database\Factories\Compliances;

use Illuminate\Support\Str;
use App\Models\Compliances\COMP01Compliances;
use Illuminate\Database\Eloquent\Factories\Factory;

class COMP01CompliancesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COMP01Compliances::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titlePage = $this->faker->text(25);
        return [
            "slug" => Str::slug($titlePage),
            "title_page" => $titlePage,
            "title_banner" => $this->faker->text(25),
            "path_image_desktop_banner" => 'uploads/tmp/bg-section-dark-gray.jpg',
            "path_image_mobile_banner" => 'uploads/tmp/port01_path_image_left.jpg',
            "background_color_banner" => '#EEE',
            "active" => 1,
        ];
    }
}
