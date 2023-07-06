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
            "title_page" => $titlePage,
            "slug" => Str::slug($titlePage),
            "title_banner" => $this->faker->text(25),
            "text" => $this->faker->text(1500),
            "path_image_banner" => 'uploads/tmp/bg-banner-inner.jpg',
            "active" => 1,
            "show_footer" => 1,
            "show_header" => 1,
        ];
    }
}
