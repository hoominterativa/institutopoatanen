<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV10Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV10ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV10Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        $title_box = $this->faker->text(10);
        return [
            'category_id' => rand(1, 4),
            'slug' => Str::slug($title. ' ' .$title_box),
            'title' => $title,
            'text' => $this->faker->text(800),
            'path_image' => $this->faker->randomElement(['uploads/tmp/image-box.jpg', 'uploads/tmp/gall01_image1.png', 'uploads/tmp/thumbnail.png']),
            'title_box' => $title_box,
            'description_box' => $this->faker->text(100),
            'path_image_box' => $this->faker->randomElement(['uploads/tmp/image-box.jpg', 'uploads/tmp/gall01_image1.png', 'uploads/tmp/thumbnail.png']),
            'path_image_icon_box' => 'uploads/tmp/favicon.png',
            'featured' => rand(0, 1),
            'active' => 1,
        ];
    }
}
