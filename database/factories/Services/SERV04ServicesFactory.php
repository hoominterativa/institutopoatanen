<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV04Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV04ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV04Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        $subtitle = $this->faker->text(12);
        return [
            'category_id' => rand(1,4),
            'title' => $title,
            'subtitle' => $subtitle,
            'slug' => Str::slug($title. ' ' .$subtitle),
            'description' => $this->faker->text(120),
            'text' => $this->faker->text(503),
            'path_image' => 'uploads/tmp/image-pmg.png',
            'path_image_box' => 'uploads/tmp/retangle.png',
            'path_image_icon' => 'uploads/tmp/icon-general.svg',
            'featured' => rand(0,1),
            'active' => 1,
        ];
    }
}
