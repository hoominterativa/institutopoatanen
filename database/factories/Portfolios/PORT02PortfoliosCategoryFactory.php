<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT02PortfoliosCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT02PortfoliosCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT02PortfoliosCategory::class;

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
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
            'featured' => 1,
        ];
    }
}
