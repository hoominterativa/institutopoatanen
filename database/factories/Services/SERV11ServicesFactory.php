<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV11Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV11ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV11Services::class;

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
            'session_id' => rand(1, 2),
            'slug' => Str::slug($title. ' ' .$subtitle),
            'title' => $title,
            'subtitle' => $subtitle,
            'text' => $this->faker->text(800),
            'description' => $this->faker->text(100),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'path_image_box' => $this->faker->randomElement(['uploads/tmp/image-box.jpg', 'uploads/tmp/gall01_image1.png', 'uploads/tmp/thumbnail.png']),
            'path_image' => $this->faker->randomElement(['uploads/tmp/image-box.jpg', 'uploads/tmp/gall01_image1.png', 'uploads/tmp/thumbnail.png']),
            'featured' => rand(0, 1),
            'active' => 1
        ];
    }
}
