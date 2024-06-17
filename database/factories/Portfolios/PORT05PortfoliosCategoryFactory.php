<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT05PortfoliosCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT05PortfoliosCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT05PortfoliosCategory::class;

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
            'active' => 1,
            'featured' => rand(0,1),
        ];
    }
}
