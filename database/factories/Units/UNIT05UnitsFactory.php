<?php

namespace Database\Factories\Units;

use Illuminate\Support\Str;
use App\Models\Units\UNIT05Units;
use Illuminate\Database\Eloquent\Factories\Factory;

class UNIT05UnitsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT05Units::class;

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
            'slug' => Str::slug($title. ' ' .$subtitle),
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $this->faker->text(70),
            'text' => $this->faker->paragraphs(2, true),
            'path_image_box' => 'uploads/tmp/bg-boxitem.png',
            'path_image_icon' => 'uploads/tmp/logo-client.svg',
            'path_image' => 'uploads/tmp/bg-boxitem.png',
            'active' => 1,
        ];
    }
}
