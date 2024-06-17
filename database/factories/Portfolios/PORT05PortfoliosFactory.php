<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT05Portfolios;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT05PortfoliosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT05Portfolios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'category_id' => rand(1,4),
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->paragraphs(3, true),
            'path_image' => 'uploads/tmp/bg-boxitem.png',
            'active' => 1,
            'featured' => rand(0, 1),
        ];
    }
}
