<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV12ServicesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV12ServicesCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV12ServicesCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(12);
        return [
            //Categories
            'slug' => Str::slug($title),
            'title' => $title,
            'text' => $this->faker->paragraphs(2, true),
            'path_image' => 'uploads/tmp/png-slide.png',
            'active' => 1,
            'featured' => rand(0,1),
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/thumbnail.png',
            'path_image_mobile_banner' => 'uploads/tmp/secaobox.png',
            'active_banner' => 1,
        ];
    }
}
