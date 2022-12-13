<?php

namespace Database\Factories\WorkWith;

use Illuminate\Support\Str;
use App\Models\WorkWith\WOWI01WorkWith;
use Illuminate\Database\Eloquent\Factories\Factory;

class WOWI01WorkWithFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WOWI01WorkWith::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titlePage = $this->faker->text(10);
        $subtitlePage = $this->faker->text(10);
        return [
            "title_banner" => $this->faker->text(18),
            "path_image_banner" => 'uploads/tmp/bg-banner-inner.jpg',
            "title_box" => $this->faker->text(10),
            "title" => $titlePage,
            "subtitle" => $subtitlePage,
            "slug" => Str::slug($titlePage.$subtitlePage),
            "description" => $this->faker->text(80),
            "text" => $this->faker->text(1000),
            "path_image_icon" => 'uploads/tmp/icon-general.svg',
            "path_image_thumbnail" => 'uploads/tmp/image-box.jpg',
            "title_section_content" => $this->faker->text(10),
            "subtitle_section_content" => $this->faker->text(10),
            "description_section_content" => $this->faker->text(250),
            "title_content" => $this->faker->text(10),
            "subtitle_content" => $this->faker->text(10),
            "description_content" => $this->faker->text(250),
            "path_image_content" => 'uploads/tmp/png-slide.png',
            "link_content" => $this->faker->url(),
            "featured_menu" => 0,
            "active" => 1,
        ];
    }
}
