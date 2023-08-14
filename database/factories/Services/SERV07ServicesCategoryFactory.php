<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV07ServicesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV07ServicesCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV07ServicesCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        $subtitle = $this->faker->text(8);
        return [
            //Category main
            "slug" => Str::slug($title),
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $this->faker->text(150),
            'path_image' => 'uploads/tmp/thumbnail-b.png',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'title_button' => $this->faker->text(10),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'active' => 1,
            'featured' => rand(0,1),

            //Additional Category Information
            'title_topic' => $this->faker->text(10),
            'subtitle_topic' => $this->faker->text(10),
            'description_topic' => $this->faker->text(200),
            'title_service' => $this->faker->text(10),
            'subtitle_service' => $this->faker->text(10),
            'description_service' => $this->faker->text(200),
            'title_banner' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/thumbnail-b.png',
            'path_image_mobile' => 'uploads/tmp/bg-slid-mobile.jpg',
            'background_color' => '#FFFFFF',
        ];
    }
}
