<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV08Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV08ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV08Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'category_id' => rand(1, 7),
            'slug' => Str::slug($title),
            'title' => $title,
            'subtitle' => $this->faker->text(12),
            'description' => $this->faker->text(120),
            'text' => $this->faker->text(500),
            'title_price' => $this->faker->text(10),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'title_featured_service' => $this->faker->text(10),
            'color_featured_service' => $this->faker->randomElement(['#6f3bed', '#e5e502', '#11e502']),
            'path_image' => $this->faker->randomElement(['uploads/tmp/image-box.jpg', 'uploads/tmp/gall01_image1.png', 'uploads/tmp/thumbnail.png']),
            'active' => 1,
            'featured_service' => rand(0, 1),
            'featured' => rand(0, 1)
        ];
    }
}
