<?php

namespace Database\Factories\Products;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products\PROD05Products;

class PROD05ProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD05Products::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(12);
        $subtitle = $this->faker->text(9);

        return [
            "category_id" =>rand(1, 5),
            "subcategory_id" =>rand(1, 5),
            "slug" => Str::slug($title.' '.$subtitle),
            'title' => $this->faker->text(10),
            "description" => $this->faker->text(190),
            "text" => $this->faker->text(500),
            "path_image_thumbnail" => 'uploads/tmp/thumbnail.png',
            "path_image" => 'uploads/tmp/port01_path_image_section.jpg',
            "path_image_banner" => 'uploads/tmp/bg-banner-inner.jpg',
            "path_image_banner_mobile" => 'uploads/tmp/bg-slid-mobile.jpg',
            "link" => $this->faker->url(),
            "title_button" => 'CTA',
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'title_section_topic' => $this->faker->text(10),
            'subtitle_section_topic' => $this->faker->text(10),
            'featured_home' => 1,
            'active' => 1,
        ];
    }
}
