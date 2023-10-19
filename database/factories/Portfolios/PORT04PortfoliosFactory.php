<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT04Portfolios;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT04PortfoliosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT04Portfolios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'category_id' => rand(1,5),
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->text(80),
            'path_image' => 'uploads/tmp/bg-boxitem.png',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
            'featured' => rand(0, 1),
        ];
    }
}
