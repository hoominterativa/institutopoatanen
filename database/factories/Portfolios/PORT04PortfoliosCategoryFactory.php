<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT04PortfoliosCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT04PortfoliosCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT04PortfoliosCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'path_image' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
