<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV05ServicesContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV05ServicesContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV05ServicesContent::class;

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
            'service_id' => rand(1,12),
            'title' => $title,
            'subtitle' => $subtitle,
            'slug' => Str::slug($title.' '.$subtitle),
            'text' => $this->faker->text(700),
            'section' => $this->faker->text(8),
            'path_image' => 'uploads/tmp/thumbnail.png',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
