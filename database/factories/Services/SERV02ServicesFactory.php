<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV02Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV02ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV02Services::class;

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
            // Service Inner
            'slug' => Str::slug($title. ' ' .$subtitle),
            'title' => $title,
            'subtitle' => $subtitle,
            'text' => $this->faker->text(500),
            'active' => 1,
            'featured' => rand(0, 1),
            // Service Box
            'title_box' => $this->faker->text(10),
            'description_box' => $this->faker->text(100),
            'path_image_box' => 'uploads/tmp/image-box.jpg',
            'path_image_icon_box' => 'uploads/tmp/favicon.png',
            // Banner Inner
            'title_banner' => $this->faker->text(12),
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#CACACA',
            'active_banner' => 1,
            // Section Inner
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(10),
            'description_section' => $this->faker->text(100),
            'active_section' => 1,
        ];
    }
}
