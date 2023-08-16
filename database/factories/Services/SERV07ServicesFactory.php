<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV07Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV07ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV07Services::class;

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
            'category_id' => rand(1,4),
            'slug' => Str::slug($title),
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $this->faker->text(100),
            'text' => $this->faker->paragraph(3),
            'path_image' => 'uploads/tmp/thumbnail.png',
            'path_image_box' => 'uploads/tmp/logo-for.png',
            'title_button' => $this->faker->text(10),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'active' => 1,
        ];
    }
}
