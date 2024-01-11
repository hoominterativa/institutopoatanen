<?php

namespace Database\Factories\Abouts;

use Illuminate\Support\Str;
use App\Models\Abouts\ABOU04Abouts;
use Illuminate\Database\Eloquent\Factories\Factory;

class ABOU04AboutsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU04Abouts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        $subtitle = $this->faker->text(10);
        return [
            'slug' => Str::slug($title. ' ' .$subtitle),
            "title" => $title,
            "subtitle" => $subtitle,
            'text' => $this->faker->text(999),
            'path_image' => 'uploads/tmp/png-slide.png',
            'active' => 1,

            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/gall01_image2.png',
            'background_color_banner' => '#FFFFFF',
            'active_banner' => 1,
            //Section Galleries
            'title_galleries' => $this->faker->text(10),
            'title_button_galleries' => $this->faker->text(10),
            'description_galleries' => $this->faker->text(100),
            'link_button_galleries' => $this->faker->url(),
            'target_link_button_galleries' => '_blank',
            'active_galleries' => 1,
            //Section Topics
            'path_image_desktop_topics' => 'uploads/tmp/gall01_image2.png',
            'path_image_mobile_topics' => 'uploads/tmp/gall01_image1.png',
            'background_color_topics' => '#FFFFFF',
            'active_topics' => 1,
        ];
    }
}
