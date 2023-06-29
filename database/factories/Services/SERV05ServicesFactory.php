<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV05Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV05ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV05Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        $subtitle = $this->faker->text(12);
        $path = $this->faker->randomElement([
            'uploads/tmp/image-box.jpg',
            'uploads/tmp/gall01_image2.png',
            'uploads/tmp/slid01_path_image_desktop.png',
        ]);
        return [
            'category_id' => rand(1, 7),
            'slug' => Str::slug($title.' '.$subtitle),
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $this->faker->text(200),
            'title_price' => $this->faker->text(12),
            'path_image' => $path,
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'price' => $this->faker->randomFloat(2, 0, 100),
            'featured' => rand(0, 1),
            'active' => 1,
        ];
    }
}
