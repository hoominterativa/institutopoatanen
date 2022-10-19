<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT01Portfolios;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT01PortfoliosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT01Portfolios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(9);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'colors' => '#6f3bed,#5cffc4,#5a5d7e,#7d00bc',
            'description' => $this->faker->text(190),
            'text' => $this->faker->text(290),
            'path_image_box' => 'uploads/tmp/port01_path_image_box.png',
            'path_image_left' => 'uploads/tmp/port01_path_image_left.jpg',
            'path_image_right' => 'uploads/tmp/port01_path_image_right.jpg',
            'title_testimonial' => $this->faker->name(),
            'subtitle_testimonial' => $this->faker->jobTitle(),
            'text_testimonial' => $this->faker->text(190),
            'path_image_testimonial' => 'uploads/tmp/port01_path_image_testmonial.png',
            'featured' => 1,
            'active' => 1,
            'category_id' => rand(1,4),
            'subcategory_id' => rand(1,4),
        ];
    }
}
