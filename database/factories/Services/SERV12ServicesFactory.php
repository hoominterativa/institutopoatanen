<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV12Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV12ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV12Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(12);
        $subtitle = $this->faker->text(12);
        return [
            'category_id' => rand(1, 5),
            'slug' => Str::slug($title. ' ' . $subtitle),
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $this->faker->text(150),
            'text' => $this->faker->paragraphs(2, true),
            'path_image' => 'uploads/tmp/png-slide.png',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
            'featured' => rand(0,1)
        ];
    }
}
